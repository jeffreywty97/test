
    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between">
                        <h5 class="mb-0">Product List</h5>
                        <a href="{{ route('products.export') }}" class="btn btn-primary">Export</a>                       
                    </div>
                    <div class="container p-2">
                        <form method="GET" action="{{ route('home') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-6">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="">
                                </div>
                                <div class="col-2">
                                    <label for="enabled" class="form-label">Status</label>
                                    <select name="enabled" id="enabled" class="form-select">
                                        <option value="">-- All --</option>
                                        <option value="1" {{ request('enabled') == '1' ? 'selected' : '' }}>Enabled</option>
                                        <option value="0" {{ request('enabled') == '0' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                </div>
                    
                                <div class="col-2">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- All --</option>
                                        @isset($categories)                                        
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                    
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>                        
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <th class="ps-4">Product Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Enabled</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($products)
                                    @foreach ($products as $product)
                                    <tr class="align-middle">
                                        <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                                        <td class="ps-4">{{$product->product_name}}</td>
                                        <td>{{$product->category->name}}</td>
                                        <td class="text-truncate" style="max-width: 200px;">{{$product->description}}</td>
                                        <td>${{number_format($product->price, 2)}}</td>
                                        <td>{{$product->stock}}</td>
                                        <td>
                                            <span class="badge bg-{{$product->enabled ? 'success' : 'secondary'}}">
                                                {{$product->enabled ? 'Yes' : 'No'}}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('products.view', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    Edit
                                                </a>
                                                <form action="{{ route('products.delete', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>                                    
                                    @endforeach                                    
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                        
                        @isset($products)
                        <div class="card-footer bg-white py-3">
                            <nav aria-label="Page navigation">
                                <div class="pagination justify-content-center mb-0">
                                    {{ $products->links() }}
                                </div>
                            </nav>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="col-3 pt-3"><button id="bulk-delete-btn" class="btn btn-danger">Bulk Delete</button></div>
        </div>
    </div>


    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        document.getElementById('bulk-delete-btn').addEventListener('click', function() {
            const ids = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(el => el.value);
            
            if (ids.length > 0) {
                confirm('Are you sure you want to delete?');
                fetch("{{ route('products.bulk_delete') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids })
                }).then(response => {
                    window.location.reload();
                });
            }else{
                alert("Please select at least one product")
            }
        });
    </script>