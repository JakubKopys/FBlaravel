{{ Form::open([ 'method'  => 'delete', 'action' => [ class_basename($model).'LikeController@destroy', $model->id ], 'class' => 'unlike-form', 'data-'.class_basename($model).'-id'=>$model->id, 'data-behavior'=> strtolower(class_basename($model)) ]) }}
    <button type="submit" class="like-link btn-link" data-{{class_basename($model)}}-id="{{$model->id}}">
        Unlike <span class="glyphicon glyphicon-thumbs-down"></span> ({{$model->likes_count}})
    </button>
{{ Form::close() }}