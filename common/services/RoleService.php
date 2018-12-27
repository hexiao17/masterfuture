<?php
namespace app\common\services;

use app\models\member\Member;
use app\models\Role;

/*
 * 会员角色服务
 * 设置角色
 *
 */
class RoleService extends BaseService
{

    /**
     * 设置会员角色
     *
     * @param unknown $member_id
     * @param unknown $role_id
     * @return boolean
     */
    public static function setMemberRole($member_id, $role_id)
    {
        $model_member = Member::findOne([
            'id' => $member_id
        ]);
        if (! $model_member) {
            return false;
        }
        $model_role = Role::findOne([
            'id' => $role_id
        ]);
        if (! $model_role) {
            return false;
        }

        $model_member->role_id = $role_id;

        $model_member->expired_time = date("Y-m-d", (time() + $model_role->valid_time * 24 * 3600));

        $model_member->updated_time = date("Y-m-d H:i:s");

        if (! $model_member->save(0)) {
            return false;
        }
        return true;
    }
}

