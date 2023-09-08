<?php

namespace App\View\Composers;
use Illuminate\View\View;
use App\Helpers\Helper;

class HelperComposer
{
  public function compose(View $view)
  {
    $view->with('helper', new Helper);
  }
}
