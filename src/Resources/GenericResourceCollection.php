<?php

	namespace iranapp\Tools\Resources;

	use Illuminate\Http\Request;
	use Illuminate\Http\Resources\Json\ResourceCollection;

	/**
	 * that is public resourceCollection
	 * sample code is
	 * return new GenericResourceCollection($categories, \App\Http\Resources\Resource::class);
	 */
	class GenericResourceCollection extends ResourceCollection
	{
		protected string $resourceClass;

		/**
		 * Constructor to accept a resource class.
		 */
		public function __construct($resource, string $resourceClass = null)
		{
			parent::__construct($resource);
			$this->resourceClass = $resourceClass ?? get_class($this->resource->first());
		}

		/**
		 * Transform the resource collection into an array.
		 *
		 * @return array<int|string, mixed>
		 */
		public function toArray(Request $request): array
		{
			return [
				'data' => ($this->resourceClass)::collection($this->collection),
				'pagination' => [
					'total' => $this->total(),
					'count' => $this->count(),
					'per_page' => $this->perPage(),
					'current_page' => $this->currentPage(),
					'total_pages' => $this->lastPage(),
				],
			];
		}
	}
