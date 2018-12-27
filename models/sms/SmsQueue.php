<?php
namespace app\models\sms;

use Yii;

/**
 * This is the model class for table "sms_queue".
 *
 * @property string $id
 * @property string $mobile
 * @property string $request_id
 * @property string $content
 * @property string $channel
 * @property integer $wx_status
 * @property integer $sms_status
 * @property string $return_msg
 * @property string $taskid
 * @property string $send_user
 * @property integer $send_number
 * @property string $updated_time
 * @property string $created_time
 * @property integer $status
 */
class SmsQueue extends \yii\db\ActiveRecord
{

    /**
     *
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_queue';
    }

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'wx_status',
                    'sms_status',
                    'send_number',
                    'status'
                ],
                'integer'
            ],
            [
                [
                    'updated_time',
                    'created_time'
                ],
                'safe'
            ],
            [
                [
                    'mobile'
                ],
                'string',
                'max' => 256
            ],
            [
                [
                    'request_id'
                ],
                'string',
                'max' => 36
            ],
            [
                [
                    'content',
                    'return_msg'
                ],
                'string',
                'max' => 255
            ],
            [
                [
                    'channel',
                    'send_user'
                ],
                'string',
                'max' => 30
            ],
            [
                [
                    'taskid'
                ],
                'string',
                'max' => 60
            ]
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'request_id' => 'Request ID',
            'content' => 'Content',
            'channel' => 'Channel',
            'wx_status' => 'Wx Status',
            'sms_status' => 'Sms Status',
            'return_msg' => 'Return Msg',
            'taskid' => 'Taskid',
            'send_user' => 'Send User',
            'send_number' => 'Send Number',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
            'status' => 'Status'
        ];
    }
}
