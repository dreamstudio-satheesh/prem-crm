<div class="card">
    <div class="card-body">
        <div class="row gy-4">
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <label for="whatsapp_telegram_group">WhatsApp/Telegram Group</label>
                        <input type="checkbox" class="form-check-input" id="whatsapp_telegram_group" wire:model="whatsapp_telegram_group">
                        @error('whatsapp_telegram_group') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <label for="auto_backup">Auto Backup</label>
                        <input type="checkbox" class="form-check-input" id="auto_backup" wire:model="auto_backup">
                        @error('auto_backup') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <label for="cloud_user">Cloud User</label>
                        <input type="checkbox" class="form-check-input" id="cloud_user" wire:model="cloud_user">
                        @error('cloud_user') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <label for="mobile_app">Mobile App</label>
                        <input type="checkbox" class="form-check-input" id="mobile_app" wire:model="mobile_app">
                        @error('mobile_app') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
