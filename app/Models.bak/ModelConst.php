<?php

namespace App\Models;

class ModelConst
{
	public const STATE_WAITING = 0;
    public const STATE_PROCESSING = 1;
    public const STATE_COMPLETED = 2;

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;
    public const STATUS_TESTGROUP = 2;

    static public function getAttributeOptions($attribute)
    {
        switch ($attribute) {
            case 'state':
                return [
                    'label' => [
                        self::STATE_WAITING => 'รอดำเนินการ',
                        self::STATE_PROCESSING => 'กำลังดำเนินการ',
                        self::STATE_COMPLETED => 'ดำเนินการเสร็จสิ้น'
                    ],
                    'color' => [
                        self::STATE_WAITING => 'warning',
                        self::STATE_PROCESSING => 'primary',
                        self::STATE_COMPLETED => 'success'
                    ],
                    'class' => [
                        self::STATE_WAITING => 'badge badge-info',
                        self::STATE_PROCESSING => 'badge badge-primary',
                        self::STATE_COMPLETED => 'badge badge-success'
                    ],
                    'icon' => [
                        self::STATE_WAITING => 'fa fa-clock',
                        self::STATE_PROCESSING => 'fa fa-spinner',
                        self::STATE_COMPLETED => 'fa fa-check'
                    ]
                ];
            case 'status':
                return [
                    'label' => [
                        self::STATUS_DISABLED => 'ปิดการใช้งาน',
                        self::STATUS_ENABLED => 'เปิดการใช้งาน',
                        self::STATUS_TESTGROUP => 'กลุ่มทดสอบ'
                    ],
                    'color' => [
                        self::STATUS_DISABLED => 'danger',
                        self::STATUS_ENABLED => 'success',
                        self::STATUS_TESTGROUP => 'warning'
                    ],
                    'class' => [
                        self::STATUS_DISABLED => 'badge badge-danger',
                        self::STATUS_ENABLED => 'badge badge-success',
                        self::STATUS_TESTGROUP => 'badge badge-warning'
                    ],
                    'icon' => [
                        self::STATUS_DISABLED => 'fa fa-times',
                        self::STATUS_ENABLED => 'fa fa-check',
                        self::STATUS_TESTGROUP => 'fa fa-flask'
                    ]
                ];
        }
    }

}