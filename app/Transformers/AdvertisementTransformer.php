<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace App\Transformers;
use App\Http\Models\Advertisement;
use League\Fractal\TransformerAbstract;
class AdvertisementTransformer extends TransformerAbstract
{
    public function transform(Advertisement $advertisement)
    {
        return [
            'id' => $advertisement->id,
            'title' => $advertisement->title,
            'sub_title' => $advertisement->sub_title,
            'image' => $advertisement->image,
            'url' => $advertisement->url,
            'created_at' => $advertisement->created_at->diffForHumans(),
            'deleted_at' => $advertisement->deleted_at,
        ];
    }
} 
