<?php

class MoviesImagesCollection extends Collection
{
    protected $table = 'movies_images';
    protected $entity = 'MoviesImagesEntity';

    public function save($object)
    {
        $data = [
            'id'        => $object->getId(),
            'image'  => $object->getImage(),
            'movies_id'  => $object->getMoviesId(),

        ];

        if (is_null($object->getId())) {
            //Insert new record
            $result = $this->insert($data);
        } else {
            //Update data
            $where = [
                'id' => $object->getId(),
            ];

            $result = $this->update($data, $where);
        }

        return $result;
    }



}
