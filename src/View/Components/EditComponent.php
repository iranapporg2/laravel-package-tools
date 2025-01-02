<?php

	namespace iranapp\Tools\View\Components;

    use Closure;
    use Illuminate\Contracts\View\View;
    use Illuminate\View\Component;

    class EditComponent extends Component {

        public $id,$key,$model,$value;

        /**
         * Create a new component instance.
         */
        public function __construct($id,$key,$model,$value) {
            $this->id = $id;
            $this->key = $key;
            $this->model = $model;
            $this->value = $value;
        }

        /**
         * Get the view / contents that represent the component.
         */
        public function render(): View|Closure|string {
            return view('components.edit-component');
        }

    }
