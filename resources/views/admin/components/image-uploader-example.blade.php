<div class="card">
    <div class="card-body">
        <h5 class="mb-3">ImageUploader Example</h5>

        <x-image-uploader id="featuredImage" name="featured_image" label="Featured Image"
            :preview-image="$tour->featured_image_url ?? null" :default-image="Vite::asset('resources/images/admin_logo.png')"
            :required="false" :max-size="2" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
    </div>
</div>

@push('scripts')
    <script type="module">
        $('#featuredImage').imageUploader({
            preview: '#featuredImage-wrapper [data-role="preview"]',
            defaultImage: "{{ Vite::asset('resources/images/admin_logo.png') }}",
            maxSize: 2,
            allowedTypes: ['jpg', 'jpeg', 'png', 'webp']
        });
    </script>
@endpush

