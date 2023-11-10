<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

interface JsonResourceful
{
    /**
     * @return string
     */
    public function getResourceType();

    /**
     * @return array
     */
    public function prepareData();

    /**
     * @return array
     */
    public function prepareIncluded();

    /**
     * @return array
     */
    public function prepareLinks();

    /**
     * @return array
     */
    public function prepareAttributes();

    /**
     * @return array
     */
    public function asJsonResource();

    /**
     * @return array
     */
    public function asJsonResourceWithRelationships();
}