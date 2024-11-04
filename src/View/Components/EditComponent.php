<?php

	namespace iranapp\Tools\View\Components;

    use Closure;
    use Illuminate\Contracts\View\View;
    use Illuminate\View\Component;

    class EditComponent extends Component {

        public $id,$key,$title,$model,$value;

        /**
         * Create a new component instance.
         */
        public function __construct($id,$key,$title,$model,$value) {
            $this->id = $id;
            $this->key = $key;
            $this->title = $title;
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
