{{ Form::open([ 'method'  => 'post', 'action' => [ class_basename($model).'LikeController@create', $model->id ], 'class' => 'like-form', 'data-'.class_basename($model).'-id'=>$model->id, 'data-behavior'=> strtolower(class_basename($model))]) }}
    <button type="submit" class="like-link btn-link" data-{{class_basename($model)}}-id="{{$model->id}}">
        Like <span class="glyphicon glyphicon-thumbs-up"></span> ({{$model->likes_count}})
    </button>
{{ Form::close() }}