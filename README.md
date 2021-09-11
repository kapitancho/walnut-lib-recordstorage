# Record Storage
A key/value based record storage abstraction

## Usages
There are several ways to use the Record Storage.

### Full example using in-memory storage and PHP serialization
```php
//Create a storage
$storage = new SerializedRecordStorage(
    new PhpArrayDataSerializer,
    new InMemoryKeyValueStorage
);
//An accessor factory for easy access
$accessorFactory = new ArrayDataAccessorFactory($recordStorage);

//Get the product storage
$accessor = $accessorFactory->accessor('products');

//Store some data
$accessor->store('product-id-1', [
    'id' => 'product-id-1', 
    'name' => 'My first product',
    'itemsInStock' => 5
]);

count($accessor->all()); //1

//Fetch the data by key
$accessor->retreive('product-id-1'); //['id' => ..., 'name' => ...]

//Fetch the data by filter
$accessor->byFilter(
    new class implements ArrayDataFilter {
		public function isSatisfiedBy(array $entry): bool {
			return $entry['itemsInStock'] > 0;
		}
	}
); //[1 record]

//Remove it
$accessor->remove('product-id-1');
//
```

### Using a JSON serializer 
```php
//Create a storage
$storage = new SerializedRecordStorage(
    new JsonArrayDataSerializer(
        new JsonSerializer
    ),
    new InMemoryKeyValueStorage
);
```

### Using an in-file storage 
```php
//Create a storage
$storage = new SerializedRecordStorage(
    new JsonArrayDataSerializer(
        new JsonSerializer
    ),
    new InFileKeyValueStorage(
        new PerFileKeyToFileNameMapper(
            baseDir: __DIR__ . '/data',
            fileExtension: 'json'
        )
    )
);
```

### Using cached storage (highly recommended)
```php
$storage = new SerializedRecordStorage(/*...*/);
$cacheableStorage = new CacheableRecordStorage($storage)
```

###More adapters and decorators
- Transaction Context decorator
- Redis Adapter
- ...other