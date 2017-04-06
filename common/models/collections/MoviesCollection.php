<?php

class MoviesCollection extends Collection
{
    protected $table = 'movies';
    protected $entity = 'MoviesEntity';


    public function save($object)
    {
        /* @var $object MoviesEntity */
        $data = [
            'id'            => $object->getId(),
            'title'         => $object->getTitle(),
            'description'   => $object->getDescription(),
            'duration'      => $object->getDuration(),
            'year'          => $object->getYear(),
            'genres'        => $object->getGenres(),
            'director'      => $object->getDirector(),
            'writers'       => $object->getWriters(),
            'cast'          => $object->getCast(),
            'rating'        => $object->getRating(),
            'cover_photo'   => $object->getCoverPhoto(),
            'youtube_link'  => $object->getYoutubeLink(),
            'language'      => $object->getLanguage(),
            'movies_categories_id'  => $object->getMoviesCategoriesId(),
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


    public function get($where = [], $offset = -1, $limit = 5, $like = [], $order = '')
    {
        $query = "SELECT  m.*, mc.title as category_title 
        FROM {$this->table} m
        Left JOIN movies_categories mc ON mc.id = m.movies_categories_id
        WHERE 1 
        ";

        $where = $this->db->escape($where);

        foreach ($where as $key => $value) {
            $query.= " AND {$key} = '{$value}' ";
        }

        if (!empty($like)) {
            $query.= " AND m.{$like[0]} LIKE '%{$like[1]}%' ";
        }

        if ($order != '') {
            $query .= " ORDER BY  '{$order}' ";
        }

        if ($offset >= 0) {
            $query .= " LIMIT {$offset}, {$limit} ";
        }


        $result = $this->db->query($query);

        if (!$result) {
            $this->db->error();
        }

        $rows = [];
        while ($row = $this->db->translate($result)) {
            $entity = new $this->entity();
            $entity->init($row);
            $rows[] = $entity;
        }


        return $rows;
    }
}

