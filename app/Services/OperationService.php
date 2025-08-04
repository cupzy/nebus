<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OperationService
{
    public function getNestedOperationIds(array $parentOperationIds): array
    {
        $placeholders = implode(',', array_fill(0, count($parentOperationIds), '?'));
        $rows = DB::select("
            WITH RECURSIVE op_tree AS (
                SELECT id
                FROM operations
                WHERE id in ($placeholders)

                UNION ALL

                SELECT op.id
                FROM operations op
                JOIN op_tree ot ON op.parent_id = ot.id
            )
            SELECT * FROM op_tree
        ", $parentOperationIds);

        return Arr::pluck($rows, 'id');
    }
}
