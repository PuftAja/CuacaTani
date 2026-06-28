<section>
    <p style="font-size:0.85rem; color:#64748b; margin-bottom:1rem; line-height:1.6;">
        Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan Anda sudah mencadangkan data penting.
    </p>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            style="padding:0.65rem 1.5rem; border:1.5px solid #fecaca; border-radius:10px; background:#fef2f2; color:#dc2626; font-size:0.85rem; font-weight:600; cursor:pointer; transition:all 0.2s; font-family:inherit;">
        🗑️ Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 style="font-size:1.1rem; font-weight:700; color:#1e293b; margin-bottom:0.5rem;">Yakin ingin menghapus akun?</h2>
            <p style="font-size:0.85rem; color:#64748b; line-height:1.6; margin-bottom:1.5rem;">
                Semua data dan lahan akan dihapus secara permanen. Masukkan password untuk konfirmasi.
            </p>

            <div style="margin-bottom:1.5rem;">
                <label for="password" style="display:block; font-size:0.82rem; font-weight:600; color:#334155; margin-bottom:0.4rem;">Password</label>
                <x-text-input id="password" name="password" type="password"
                    style="width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e2e8f0; border-radius:10px; font-size:0.9rem; background:#f8fafc; font-family:inherit;"
                    placeholder="Masukkan password Anda" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        style="padding:0.65rem 1.25rem; border:1.5px solid #e2e8f0; border-radius:10px; color:#64748b; font-size:0.85rem; font-weight:500; background:white; cursor:pointer; font-family:inherit;">
                    Batal
                </button>
                <button type="submit"
                        style="padding:0.65rem 1.25rem; border:none; border-radius:10px; background:#dc2626; color:white; font-size:0.85rem; font-weight:600; cursor:pointer; font-family:inherit;">
                    🗑️ Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
