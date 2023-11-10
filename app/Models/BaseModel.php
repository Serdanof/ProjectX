<?php

namespace App\Models;
use Eloquent as Model;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
/**
 * Class BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 *
 * @mixin Model
 */
class BaseModel extends Model
{
    use HasFactory;
      /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPerPage(): int
    {
        $pageSize = request()->get('page_size');
        if ($pageSize == 0) {
            $count = static::count();
            if ($count > 0) {
                return $count;
            }
        }

        return $this->perPage;
    }
}
