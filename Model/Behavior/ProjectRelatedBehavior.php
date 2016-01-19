<?php

class ProjectRelatedBehavior extends ModelBehavior
{

    public function beforeFind(Model $model, $query)
    {
        $pid = AuthComponent::user('project_id');
        $uid = AuthComponent::user('id');
        if (!$query['conditions']) $query['conditions'] = array();
        if($model->alias == 'MailingOption') {
            $query['conditions']['OR'][$model->alias . '.user_id'] = $uid;
            $query['conditions']['OR'][$model->alias . '.project_id'] = $pid;
        } else
            $query['conditions'][$model->alias . '.project_id'] = $pid;
        return $query;
    }

    public function beforeSave(Model $model, $options = array())
    {
        $pid = AuthComponent::user('project_id');
        $uid = AuthComponent::user('id');
        if ($model->alias == 'MailingOption') {
            if($model->data[$model->alias]['is_projectwide'] == 0) {
                $model->set('project_id', null);
                $model->set('user_id', $uid);
            } else {
                $model->set('project_id', $pid);
                $model->set('user_id', null);
            }
        } else {
            $model->set('project_id', $pid);
        }
        return true;
    }
}