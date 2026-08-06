@props(['id', 'name', 'value' => ''])

<input id="{{ $id }}" type="hidden" name="{{ $name }}" value="{{ $value }}">

<div id="{{ $id }}-toolbar" class="quill-toolbar">
    <span class="ql-formats">
        <select class="ql-font"></select>
        <select class="ql-size"></select>
    </span>
    <span class="ql-formats">
        <select class="ql-header">
            <option value="1"></option>
            <option value="2"></option>
            <option value="3"></option>
            <option value="4"></option>
            <option value="5"></option>
            <option value="6"></option>
            <option selected></option>
        </select>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-bold"></button>
        <button type="button" class="ql-italic"></button>
        <button type="button" class="ql-underline"></button>
        <button type="button" class="ql-strike"></button>
    </span>
    <span class="ql-formats">
        <select class="ql-color"></select>
        <select class="ql-background"></select>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-script" value="sub"></button>
        <button type="button" class="ql-script" value="super"></button>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-blockquote"></button>
        <button type="button" class="ql-code-block"></button>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-list" value="ordered"></button>
        <button type="button" class="ql-list" value="bullet"></button>
        <button type="button" class="ql-indent" value="-1"></button>
        <button type="button" class="ql-indent" value="+1"></button>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-direction" value="rtl"></button>
        <select class="ql-align"></select>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-link"></button>
        <button type="button" class="ql-image"></button>
        <button type="button" class="ql-video"></button>
    </span>
    <span class="ql-formats">
        <button type="button" class="ql-clean"></button>
    </span>
</div>
<div id="{{ $id }}-container" {{ $attributes }}>{!! $value !!}</div>

<script>
    (function () {
        // Quill terima "google.com" apa adanya sebagai href — browser lalu
        // menganggapnya path relatif ke halaman saat ini (jadi kebuka
        // ".../google.com", bukan ke situs google.com). Timpa sanitizer bawaan
        // link supaya link tanpa skema otomatis ditambah "https://", sementara
        // link internal ("/kategori/produk") dan anchor ("#bagian") dibiarkan.
        if (!window.__quillAutoProtocolLinkRegistered) {
            var BaseLink = Quill.import('formats/link');
            var hasSchemeOrIsRelative = /^[a-z][a-z0-9+.-]*:|^[/#]/i;

            class AutoProtocolLink extends BaseLink {
                static sanitize(url) {
                    var value = super.sanitize(url);
                    if (!value || hasSchemeOrIsRelative.test(value)) {
                        return value;
                    }
                    return 'https://' + value;
                }
            }

            Quill.register(AutoProtocolLink, true);
            window.__quillAutoProtocolLinkRegistered = true;
        }

        function init() {
            var hiddenInput = document.getElementById(@js($id));
            var quill = new Quill(document.getElementById(@js($id . '-container')), {
                theme: 'snow',
                modules: {
                    toolbar: {
                        container: document.getElementById(@js($id . '-toolbar')),
                        handlers: {
                            image: function () {
                                var input = document.createElement('input');
                                input.setAttribute('type', 'file');
                                input.setAttribute('accept', 'image/png,image/jpeg,image/webp,image/gif');
                                input.click();

                                input.onchange = function () {
                                    var file = input.files[0];
                                    if (!file) return;

                                    var range = quill.getSelection(true);
                                    var formData = new FormData();
                                    formData.append('image', file);

                                    fetch(@js(route('admin.editor.image')), {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        },
                                        body: formData,
                                    })
                                        .then(function (res) {
                                            if (!res.ok) throw new Error('upload failed');
                                            return res.json();
                                        })
                                        .then(function (data) {
                                            quill.insertEmbed(range.index, 'image', data.url, 'user');
                                            quill.setSelection(range.index + 1);
                                        })
                                        .catch(function () {
                                            alert('Gagal mengunggah gambar. Coba lagi.');
                                        });
                                };
                            },
                        },
                    },
                },
            });

            // Konten awal sudah dirender langsung di dalam #{{ $id }}-container (server-side) —
            // Quill membaca isinya sendiri saat konstruksi, jadi tidak perlu di-inject manual
            // lewat innerHTML di sini (yang tidak akan jalan kalau CDN Quill gagal/telat dimuat).
            function syncHiddenInput() {
                var html = quill.root.innerHTML;
                hiddenInput.value = html === '<p><br></p>' ? '' : html;
            }

            quill.on('text-change', syncHiddenInput);

            var form = hiddenInput.closest('form');
            if (form) {
                form.addEventListener('submit', syncHiddenInput);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
</script>
