<?php

namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignRoleEvent extends  Event
{
	
	public $project;
	public $user;
	public $role;
	
	public function dump()
	{
		return [
				'project' => $this->project->project_id,
				'user' => $this->user->id,
				'role' => $this->role
		];
	}
}

class ProjectService extends Component
{
	const EVENT_ASSIGN_ROLE= 'event_assign_role';
	
	public function assignRole(Project $project, User $user, $role)
	{
		
		
		$event = new AssignRoleEvent();
		$event->project = $project;
		$event->user = $user;
		$event->role = $role;
		$this->trigger(self::EVENT_ASSIGN_ROLE, $event);
	}
	
	public function getRoles(Project $project, User $user) {
		$roles = $project->getProjectUsers()->byUser($user->id)->select('role')->column();
		
		$roles_labels = [];
		
		foreach($roles as $role) {
			array_push($roles_labels, \common\models\ProjectUser::ROLE_LABELS[$role]);
		}
		
		return $roles_labels;
	}
	
	public function hasRole(Project $project, User $user, $role) {
		return in_array($role, $this->getRoles($project, $user));
	}

}