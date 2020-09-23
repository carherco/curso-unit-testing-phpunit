<?php

namespace App;

class PricingService
{   
    /**
     * Crea el objeto del rate para pintar el 
     * xml en el formato deseado
     * @param  array $rate Array con los datos de la rate sacado
     *        de la base de datos.
     * @return \Model\Policy\Rate
     */
    protected function renderObject( $data, $photos )
    {
        $activity = new ActivityDetailsModel();
        $activity->setId( $data['id'] );
        $activity->setName( $data['name'] );
        $activity->setCategory( $this->category2Model( $data['categoryId'], $data['categoryName'] ) );
        $activity->setSubCategory( $this->subcategory2Model( $data['subcategoryId'], $data['subcategoryName'] ) );
        $activity->setDescription( $data['description'] );
        $activity->setConditions( $data['conditions'] );

        $activity->setLocation( $this->location2Model($data) );
        $activity->setImages( $this->photos2Model( $photos ) );
        return $activity;
    }

    protected function category2Model( $id, $name ) 
    {
        $cat = new CategoryModel();
        $cat->setId( $id );
        $cat->setName( $name );

        return $cat;
    }

    protected function subcategory2Model( $id, $name ) 
    {
        $cat = new SubcategoryModel();
        $cat->setId( $id );
        $cat->setName( $name );

        return $cat;
    } 

    protected function location2Model( $data )
    {
        $location = new LocationModel();
        $location->setCity( $data['city'] );
        $location->setCountry( $data['country'] );
        $location->setLatitude( $data['latitude'] );
        $location->setLongitude( $data['longitude'] );
        $location->setAddress( $data['address'] );

        return $location;
    }

    protected function photos2Model( $photos ) 
    {
        $rs = array();
        if ( is_array($photos) && !empty($photos) ) {
            foreach ($photos as $photo) {
                $ph = new PhotoModel();
                $ph->setPath( $this->getGlobalPath( $photo['name'] ) );
                $rs[] = $ph;
            }
        }
        return $rs;
    } 

    private function getGlobalPath($name) {
        return '/some/path/' + $name;
    }

}