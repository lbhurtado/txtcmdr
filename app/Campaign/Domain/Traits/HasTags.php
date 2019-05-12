<?php

namespace App\Campaign\Domain\Traits;

use Illuminate\Support\Str;
use App\Campaign\Domain\Models\Tag;

trait HasTags
{
//    public function tags()
//    {
//        return $this->morphOne(Tag::class, 'tagger');
//    }

    public function tag()
    {
        return $this->hasOne(Tag::class, 'contact_id');
    }

    public function syncTag($code)
    {
        $contact_id = $this->id;

        return $this->tag()->updateOrCreate(compact('contact_id'), compact('code'));
    }

    public function addTag($code)
    {
        $contact_id = $this->id;

        return $this->tag()->firstOrCreate(compact('contact_id','code'));
    }

    public function setTag($code)
    {
        $this->syncTag($code);

        return $this;
    }

//    public function syncTag($code)
//    {
//        $this->tags()->delete();
//
//        return $this->tags()->create(compact('code'));
//    }

    // public function removeTags()
    // {
    // 	$this->tags->each(function ($tag) {
    // 		$this->removeTaggables($tag, [])->delete();
    // 	});
    // }

  //   public function removeTaggables(Tag $tag, ...$indices)
  //   {
  //   	$indices = $this->process($indices);

		// foreach ($indices as $index) {
		// 	$relation = str_plural(Str::snake($index));
		// 	$tag->{$relation}()->detach();
		// };

		// return $tag;
  //   }

  //   protected function process($indices)
  //   {
  //   	$indices = array_flatten($indices);

  //   	return (count($indices) == 0)
  //   		   ? ['area', 'role', 'group', 'campaign']
  //   		   : $indices
  //   		   ;
  //   }
}
