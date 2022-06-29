<?php

namespace App\View\Components\expense;

use Illuminate\View\Component;

class newExpencecomponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $expense_type;
    public function __construct($expense_type)
    {
        $this->expense_type=$expense_type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.expense.new-expencecomponent',['expense_type'=>$this->expense_type]);
    }
}
