<?php

	namespace iranapp\Tools\Services;

	use Illuminate\Http\UploadedFile;
	use Symfony\Component\HttpFoundation\FileBag;

	class UploaderService
	{
		/**
		 * Upload a single file to the specified path.
		 *
		 * @param UploadedFile $file
		 * @param string $path
		 * @param string $disk
		 * @return UploaderResult
		 */
		public static function uploadFile(UploadedFile $file, string $path, string $disk = 'public'): UploaderResult
		{
			$storedPath = $file->store($path, ['disk' => $disk]);

			return new UploaderResult(
				$storedPath !== false,
				$storedPath
			);
		}

		/**
		 * Upload multiple files to the specified path.
		 *
		 * @param FileBag $files
		 * @param string $path
		 * @param string $disk
		 * @return UploaderResult[]
		 */
		public static function uploadFiles(FileBag $files, string $path, string $disk = 'public'): array
		{
			$results = [];

			foreach ($files as $file) {
				$storedPath = $file->store($path, ['disk' => $disk]);

				$results[] = new UploaderResult(
					$storedPath !== false,
					$storedPath
				);
			}

			return $results;
		}
	}

	class UploaderResult
	{
		private bool $status;
		private ?string $path;

		/**
		 * Constructor to initialize the upload result.
		 *
		 * @param bool $status
		 * @param string|null $path
		 */
		public function __construct(bool $status, ?string $path)
		{
			$this->status = $status;
			$this->path = $path;
		}

		/**
		 * Check if the upload was successful.
		 *
		 * @return bool
		 */
		public function isSuccess(): bool
		{
			return $this->status;
		}

		/**
		 * Get the stored file path.
		 *
		 * @return string|null
		 */
		public function getPath(): ?string
		{
			return $this->path;
		}
	}
