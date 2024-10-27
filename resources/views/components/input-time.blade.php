@props(['name', 'label', 'value' => ''])

<div class="mb-3 time-picker-component" x-data="customTimePicker('{{ $value }}')">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>

    <div class="position-relative">
        <input type="text" class="form-control" name="{{ $name }}" x-model="displayTime"
            x-on:click="togglePicker()" readonly />

        <!-- Time Picker Dropdown -->
        <div class="time-picker-dropdown shadow" x-show="isOpen" x-transition x-on:click.away="isOpen = false"
            style="display: none;">
            <div class="d-flex align-items-center p-3 gap-3">
                <!-- Hours -->
                <div class="time-column">
                    <button type="button" class="btn btn-link w-100 p-1" x-on:click="incrementHour">▲</button>
                    <input type="text" class="form-control text-center" x-model="hours" readonly />
                    <button type="button" class="btn btn-link w-100 p-1" x-on:click="decrementHour">▼</button>
                </div>

                <div class="time-separator">:</div>

                <!-- Minutes -->
                <div class="time-column">
                    <button type="button" class="btn btn-link w-100 p-1" x-on:click="incrementMinute">▲</button>
                    <input type="text" class="form-control text-center" x-model="minutes" readonly />
                    <button type="button" class="btn btn-link w-100 p-1" x-on:click="decrementMinute">▼</button>
                </div>
            </div>

            <div class="p-2 border-top d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-sm btn-secondary" x-on:click="isOpen = false">Cancelar</button>
                <button type="button" class="btn btn-sm btn-primary" x-on:click="confirmTime">OK</button>
            </div>
        </div>
    </div>
</div>

<style>
    .time-picker-component {
        position: relative;
    }

    .time-picker-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        width: 250px;
        margin-top: 0.5rem;
    }

    .time-picker-dropdown[x-cloak] {
        display: none !important;
    }

    .time-column {
        width: 80px;
    }

    .time-column input {
        border-radius: 0;
        border-left: none;
        border-right: none;
        font-size: 1.5rem;
        padding: 0.25rem;
    }

    .time-separator {
        font-size: 1.5rem;
        font-weight: bold;
        padding: 0 0.5rem;
    }

    .btn-link {
        color: #6366f1;
        text-decoration: none;
    }

    .btn-link:hover {
        color: #4f46e5;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customTimePicker', (initialValue = '') => ({
            isOpen: false,
            hours: '00',
            minutes: '00',
            displayTime: '',

            init() {
                this.parseInitialValue(initialValue);
            },

            parseInitialValue(value) {
                if (!value) {
                    this.updateDisplayTime();
                    return;
                }

                try {
                    let [hours, minutes] = value.split(':');
                    this.hours = hours.padStart(2, '0');
                    this.minutes = minutes.padStart(2, '0');
                    this.updateDisplayTime();
                } catch (e) {
                    console.error('Error parsing time value:', e);
                    this.hours = '00';
                    this.minutes = '00';
                    this.updateDisplayTime();
                }
            },

            togglePicker() {
                this.isOpen = !this.isOpen;
            },

            incrementHour() {
                let hour = parseInt(this.hours);
                hour = (hour + 1) % 24;
                this.hours = hour.toString().padStart(2, '0');
                this.updateDisplayTime();
            },

            decrementHour() {
                let hour = parseInt(this.hours);
                hour = (hour - 1 + 24) % 24;
                this.hours = hour.toString().padStart(2, '0');
                this.updateDisplayTime();
            },

            incrementMinute() {
                let minute = parseInt(this.minutes);
                minute = (minute + 1) % 60;
                this.minutes = minute.toString().padStart(2, '0');
                this.updateDisplayTime();
            },

            decrementMinute() {
                let minute = parseInt(this.minutes);
                minute = (minute - 1 + 60) % 60;
                this.minutes = minute.toString().padStart(2, '0');
                this.updateDisplayTime();
            },

            updateDisplayTime() {
                this.displayTime = `${this.hours}:${this.minutes}`;
            },

            confirmTime() {
                this.updateDisplayTime();
                this.isOpen = false;
            }
        }));
    });
</script>
