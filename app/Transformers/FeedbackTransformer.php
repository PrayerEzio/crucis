<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan. 
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna. 
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus. 
 * Vestibulum commodo. Ut rhoncus gravida arcu. 
 */

namespace App\Transformers;
use App\Http\Models\Feedback;
use League\Fractal\TransformerAbstract;
class FeedbackTransformer extends TransformerAbstract
{
    public function transform(Feedback $feedback)
    {
        return [
            'id' => $feedback->id,
            'user' => $feedback->user,
            'user_id' => $feedback->user_id,
            'content' => $feedback->content,
            'picture' => $feedback->pictures,
            'created_at' => $feedback->created_at->diffForHumans(),
            'deleted_at' => $feedback->deleted_at,
        ];
    }
} 
