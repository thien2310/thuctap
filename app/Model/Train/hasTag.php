<?php

namespace App\Model\Train;


use App\Model\Admin\Tag;
use App\Model\admin\Tagable;

trait hasTag
{

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tagable');
    }



    public function addTag($tag_ids)
    {
        foreach ($tag_ids as $tag_id) {

            Tagable::query()->create([
                'tagable_type' => get_class($this),
                'tagable_id' => $this->id,
                'tag_id' => $tag_id
            ]);
        }
    }


    public function updateTags($tag_ids) {

        $tag_ids_current = $this->tags->pluck('id')->toArray();

        $tag_ids_delete = array_diff($tag_ids_current, $tag_ids);
        // dd($tag_ids_delete);

        Tagable::query()->where([
            'tagable_id' => $this->id,
            'tagable_type' => get_class($this),
        ])->whereIn('tag_id', $tag_ids_delete)->delete();

        foreach ($tag_ids as $tag_id) {
            $exists = Tagable::query()->where([
                'tagable_id' => $this->id,
                'tagable_type' => get_class($this),
                'tag_id' => $tag_id,
            ])->exists();
            if(! $exists) {
                Tagable::query()->create([
                    'tagable_id' => $this->id,
                    'tagable_type' => get_class($this),
                    'tag_id' => $tag_id
                ]);
            }

        }
    }
}
