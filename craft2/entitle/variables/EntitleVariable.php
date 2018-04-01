<?php namespace Craft;

class EntitleVariable
{
    public function capitalize($string)
    {
        return craft()->entitle->capitalize($string);
    }
}
