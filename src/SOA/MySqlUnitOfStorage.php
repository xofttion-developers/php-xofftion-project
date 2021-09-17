<?php

namespace Xofttion\Project\SOA;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Xofttion\ORM\Contracts\IModel;
use Xofttion\SOA\UnitOfStorage;
use Xofttion\Project\Authenticated;
use Xofttion\Project\ORM\Utils\MySqlCode;
use Xofttion\Project\ORM\Model;
use Xofttion\Project\ORM\ModelHidden;

class MySqlUnitOfStorage extends UnitOfStorage
{

    // Métodos sobrescritos de la clase BaseUnitOfStorage

    protected function insert(IModel $model): void
    {
        if ($model instanceof Model) {
            $model[Model::CREATED_USER] = Authenticated::getInstance()->getUserId();
            $model[Model::CREATED_AT] = $this->getDateTimeFormat();
        }

        parent::insert($model);
    }

    protected function update(IModel $model): void
    {
        if ($model instanceof Model) {
            $model[Model::UPDATED_USER] = Authenticated::getInstance()->getUserId();
            $model[Model::UPDATED_AT] = $this->getDateTimeFormat();
        }

        parent::update($model);
    }

    protected function delete(IModel $model): void
    {
        try {
            parent::delete($model);
        }
        catch (QueryException $ex) {
            if (($ex->errorInfo[1] == MySqlCode::FK_CONSTRAINS_PARENT)) {
                $this->hidden($ex, $model);
            }
            else {
                throw $ex;
            }
        }
    }

    // Métodos de la clase MySqlUnitOfStorage

    /**
     * 
     * @param QueryException $ex
     * @param IModel $model
     */
    private function hidden(QueryException $ex, IModel $model)
    {
        if ($model instanceof ModelHidden) {
            $model[ModelHidden::DELETED_USER] = Authenticated::getInstance()->getUserId();
            $model[ModelHidden::DELETED_ROW] = true;
            $model[ModelHidden::DELETED_AT] = $this->getDateTimeFormat();

            $this->getStorage(get_class($model))->safeguard($model);
        }
        else {
            throw $ex;
        }
    }

    /**
     * 
     * @return string
     */
    private function getDateTimeFormat(): string
    {
        return Carbon::createFromTimestamp($this->getNow())->toDateTimeString();
    }
}
