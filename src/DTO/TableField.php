<?php
namespace Ivene\AutoCode\DTO;
/**
 * @description
 * @author YaoYao
 * @time 2023/8/15 16:23
 */
class TableField
{
    public string $name;
    public string $title;
    public string $type;
    public string $comment;
    public string $validation="";
    public mixed $enums;
}
