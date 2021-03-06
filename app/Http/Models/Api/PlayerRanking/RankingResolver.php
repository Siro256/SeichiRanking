<?php

namespace App\Http\Models\Api\PlayerRanking;

use DB;
use Illuminate\Database\Query\Builder;
use Log;

abstract class RankingResolver
{
    abstract function getRankComparator();

    abstract function getRankingType();

    /**
     * DBから取得した生のデータカラムをIPlayerData構造体に変換する
     * @param $raw_column mixed
     * @return array IPlayerDataの仕様に従ったarray
     * @internal param int $playtick プレイ時間(tick)
     */
    protected function toPlayerDataObject($raw_column) {
        return [
            'raw_data' => "$raw_column"
        ];
    }

    private function toPlayerRank($fetched_player_row)
    {
        if ($fetched_player_row == null) {
            return null;
        }

        return [
            "player" => [
                'name' => $fetched_player_row->name,
                'uuid' => $fetched_player_row->uuid,
            ],
            "type" => $this->getRankingType(),
            "rank" => $fetched_player_row->rank,
            "data" => $this->toPlayerDataObject($fetched_player_row->data),
            "lastquit" => $fetched_player_row->lastquit
        ];
    }

    /**
     * ランキング全体を取得するためのクエリを取得する
     * @return Builder
     */
    private function getRankingQuery()
    {
        $comparator = $this->getRankComparator();

        // ref. http://blog.phalusamil.com/entry/2015/09/23/094536
        return DB::table(DB::raw(<<<EOT
(SELECT $comparator, @rank AS rank, cnt, @rank := @rank + cnt FROM (SELECT @rank := 1) AS Dummy,
(SELECT $comparator, count(*) AS cnt FROM playerdata GROUP BY $comparator ORDER BY $comparator DESC) AS GroupBy
) AS Ranking
JOIN playerdata ON playerdata.$comparator = Ranking.$comparator
EOT
        ))
            // rankがなぜか文字列で取得されていたのでSIGNEDにキャスト
            ->selectRaw("name, uuid, CAST(rank AS SIGNED) as rank, playerdata.$comparator as data, playerdata.lastquit as lastquit")
            ->where("playerdata.$comparator", '>', 0)
            ->orderBy('rank', 'ASC')
            ->orderBy('name');
    }

    /**
     * ランキングの一部を取得する
     * @param $offset integer オフセットの大きさ
     * @param $limit integer 取得するランキングのサイズ
     * @return array IPlayerRankの配列
     */
    public function getRanking($offset, $limit)
    {
        $fetched_player_rows = $this->getRankingQuery()->limit($limit)->offset($offset)->get();

        $ranked_players = [];

        foreach ($fetched_player_rows as $player_row) {
            $ranked_players[] = $this->toPlayerRank($player_row);
        }

        return $ranked_players;
    }

    /**
     * 指定プレーヤーの順位を取得する
     * @param $player_uuid string プレーヤーのUUID
     * @return array|null IPlayerRankの配列/プレーヤーの順位が存在しない場合はnull
     */
    public function getPlayerRank($player_uuid)
    {
        $player_row = $this->getRankingQuery()->where('uuid', $player_uuid)->first();

        return $this->toPlayerRank($player_row);
    }

    /**
     * ランキングに含まれるプレーヤーの総数を返す。レコードが0又は無効の場合は除外される。
     */
    public function getPlayerCount()
    {
        return DB::table('playerdata')
            ->select('uuid')
            ->where($this->getRankComparator(), '>', 0)
            ->count();
    }
}