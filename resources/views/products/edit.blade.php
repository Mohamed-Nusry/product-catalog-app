@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="mb-4">Edit Product</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mb-4">Go Back</a>


        <!-- Form to edit a product -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Edit Fields -->
            <div class="form-group">
                <label for="code">Code *:</label>
                <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}" class="form-control" required>
                @error('code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Category *:</label>
                <input type="text" id="category" name="category" value="{{ old('category', $product->category) }}" class="form-control" required>
                @error('category')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Name *:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price *:</label>
                <input type="number" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}" step="0.01" class="form-control" required>
                @error('selling_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="special_price">Special Price:</label>
                <input type="number" id="special_price" name="special_price" value="{{ old('special_price', $product->special_price) }}" step="0.01" class="form-control">
                @error('special_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <br>

            <div class="form-group">
                <label for="image">Image *:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>

            <div class="form-group">
                <label for="status">Status *:</label>
                <select id="status" name="status" class="form-control">
                    <option value="Draft" {{ old('status', $product->status) === 'Draft' ? 'selected' : '' }}>Draft</option>
                    <option value="Published" {{ old('status', $product->status) === 'Published' ? 'selected' : '' }}>Published</option>
                    <option value="Out of Stock" {{ old('status', $product->status) === 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_delivery_available">Is Delivery Available *:</label>
                <select id="is_delivery_available" name="is_delivery_available" class="form-control" required>
                    <option value="">Select</option>
                    <option value="1" {{ old('is_delivery_available', $product->is_delivery_available) === 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_delivery_available', $product->is_delivery_available) === 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_delivery_available')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <br>
            <h3 class="">Attributes</h3>
            <!-- Attributes Section -->
            <div id="attributes">
                @foreach($product->attributes as $index => $attribute)
                    <div class="attribute-group">
                        <div class="form-row align-items-center">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="attributes[{{ $index }}][name]" class="form-control" value="{{ old('attributes.' . $index . '.name', $attribute->name) }}" placeholder="Attribute Name *" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <input type="text" name="attributes[{{ $index }}][attribute_value]" class="form-control" value="{{ old('attributes.' . $index . '.attribute_value', $attribute->attribute_value) }}" placeholder="Attribute Value *" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="button" class="btn btn-danger remove-attribute">Remove</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <br>
            <br>

            <!-- Add Attribute Button -->
            <button type="button" id="add-attribute" class="btn btn-success">Add Attribute</button>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            var attributeIndex = {{ $product->attributes->count() }}; // Start index for new attributes

            $('#add-attribute').click(function() {
                var newAttribute = `
                    <div class="attribute-group">
                        <div class="form-row align-items-center">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="attributes[${attributeIndex}][name]" class="form-control" placeholder="Attribute Name" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <input type="text" name="attributes[${attributeIndex}][value]" class="form-control" placeholder="Attribute Value" required>
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="button" class="btn btn-danger remove-attribute">Remove</button>
                            </div>
                        </div>
                    </div>
                `;
                $('#attributes').append(newAttribute);
                attributeIndex++;
            });

            $(document).on('click', '.remove-attribute', function() {
                $(this).closest('.attribute-group').remove();
            });
        });
    </script>
    
@endsection