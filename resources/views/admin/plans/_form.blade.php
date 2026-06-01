@php $planFeatures = old('features', $plan->features ?? []); @endphp

<div class="row">
  <div class="col-md-8">
    <div class="form-group">
      <label>Plan Name <span class="text-danger">*</span></label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name ?? '') }}" required>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Sort Order</label>
      <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order ?? 0) }}" min="0">
    </div>
  </div>
</div>

<div class="form-group">
  <label>Description</label>
  <textarea name="description" class="form-control" rows="2">{{ old('description', $plan->description ?? '') }}</textarea>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label>Price (₹) <span class="text-danger">*</span></label>
      <input type="number" name="price" class="form-control" value="{{ old('price', $plan->price ?? 0) }}" min="0" step="0.01" required>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      <label>Billing Interval <span class="text-danger">*</span></label>
      <select name="billing_interval" class="form-control" required>
        @foreach(['month' => 'Monthly', 'year' => 'Yearly', 'lifetime' => 'Lifetime (free)'] as $val => $lbl)
          <option value="{{ $val }}" {{ old('billing_interval', $plan->billing_interval ?? 'month') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>

<div class="form-group">
  <label>Features included <small class="text-muted">(what this plan unlocks)</small></label>
  <div class="row">
    @foreach($features as $key => $label)
      <div class="col-md-6">
        <label class="d-flex align-items-center" style="gap:8px;font-weight:normal">
          <input type="checkbox" name="features[]" value="{{ $key }}" {{ in_array($key, $planFeatures) ? 'checked' : '' }}>
          <span>{{ $label }} <code>{{ $key }}</code></span>
        </label>
      </div>
    @endforeach
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label class="d-flex align-items-center" style="gap:8px">
        <input type="checkbox" name="is_free" value="1" {{ old('is_free', $plan->is_free ?? false) ? 'checked' : '' }}>
        <span>This is the <strong>Free</strong> plan (not purchasable)</span>
      </label>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="d-flex align-items-center" style="gap:8px">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }}>
        <span><strong>Active</strong> (visible on pricing page)</span>
      </label>
    </div>
  </div>
</div>
