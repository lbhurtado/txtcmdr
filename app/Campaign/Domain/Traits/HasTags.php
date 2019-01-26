<?php

namespace App\Campaign\Domain\Traits;

use Illuminate\Support\Str;
use App\Campaign\Domain\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return $this->morphOne(Tag::class, 'tagger');
    }

    public function syncTag($code)
    {
        $this->tags()->delete();
        $this->tags()->create(compact('code'));
    }

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