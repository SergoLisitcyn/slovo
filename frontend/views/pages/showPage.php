<?php
if(isset($model->title) && !empty($model->title)) { $this->title = $model->title; }
if(isset($model->keywords) && !empty($model->keywords)) { $this->registerMetaTag(['name' => 'keywords','content' => $model->keywords]); }
if(isset($model->description) && !empty($model->description)) { $this->registerMetaTag(['name' => 'description','content' => $model->description]); }
?>
<div class="get-money-form text-page">
    <?php echo $model->content ?>
</div>