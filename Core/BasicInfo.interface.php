<?php
interface BasicInfo
{
    public function getFullDescription($itemType = true);
    public function getCost();
    public function getName();
    public function getProductGroup();
}