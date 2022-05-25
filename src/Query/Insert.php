<?php

declare(strict_types=1);

namespace Src\Query;

use Src\Log\Log;
use Src\Query\SQLStatement;

final class Insert extends SQLStatement
{

    public function exec()
    {
        $this->connection->prepare($this->build());
        $this->connection->beginTransaction();
        try {
            // 処理
            $this->connection->commit();
            return 1;
        } catch (\PDOException $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    protected function build()
    {
        return true;
    }
}
