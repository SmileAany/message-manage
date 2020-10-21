<?php

namespace Smbear\MessageManage\Interfaces;

interface EmailInterface
{
    public function getViewByType(int $type):string;
}