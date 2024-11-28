<?php

    namespace iranapp\Tools\Responses;

    use Illuminate\Http\RedirectResponse;

    class CustomRedirectResponse extends RedirectResponse  {

        /**
         * Add a notification message to the session.
         *
         * @param string $message
         * @return RedirectResponse
         */
        public function notify(string $message,$data = null,$type = null) {

			if ($type != null) $this->with('type',$type);
			if ($data != null) $this->with('data',$data);

            return $this->with('notify', $message);

        }

    }
