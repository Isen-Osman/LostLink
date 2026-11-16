@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('location');
            const list = document.getElementById('location-suggestions');

            if (!input || !list) {
                return;
            }

            const url = @json(route('locations.index', absolute: false));
            let timer;

            const hide = () => {
                list.innerHTML = '';
                list.classList.add('hidden');
            };

            const render = (suggestions) => {
                list.innerHTML = '';

                if (suggestions.length === 0) {
                    hide();
                    return;
                }

                suggestions.forEach(({ label }) => {
                    const item = document.createElement('li');
                    item.className = 'cursor-pointer px-3 py-2 text-sm text-slate-700 hover:bg-slate-100';
                    item.textContent = label;
                    item.addEventListener('click', () => {
                        input.value = label;
                        hide();
                    });
                    list.appendChild(item);
                });

                list.classList.remove('hidden');
            };

            input.addEventListener('input', () => {
                clearTimeout(timer);
                const query = input.value.trim();

                if (query.length < 3) {
                    hide();
                    return;
                }

                timer = setTimeout(async () => {
                    const response = await fetch(`${url}?q=${encodeURIComponent(query)}`, {
                        headers: { Accept: 'application/json' },
                    });

                    if (!response.ok) {
                        hide();
                        return;
                    }

                    const { data } = await response.json();
                    render(data);
                }, 300);
            });

            input.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    hide();
                }
            });

            document.addEventListener('click', (event) => {
                if (!input.contains(event.target) && !list.contains(event.target)) {
                    hide();
                }
            });
        });
    </script>
@endpush
