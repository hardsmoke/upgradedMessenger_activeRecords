<?php

namespace Messenger\View;

interface IView
{
    public function Render(string $pageName) : string;
}