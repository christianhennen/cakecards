<?php

class ProjectRelatedBehavior extends ModelBehavior
{

    public function beforeFind(Model $model, $query)
    {
        $pid = AuthComponent::user('project_id');
        $query['conditions'] = array($model->alias.'.project_id' => $pid);
        return $query;
    }

    public function beforeSave(Model $model, $options = array())
    {
        $pid = AuthComponent::user('project_id');
        $model->set('project_id',$pid);
        return true;
    }
}