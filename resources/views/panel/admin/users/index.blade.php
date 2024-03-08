@extends('panel.layout.app')
@section('title', __('User Management'))

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
                    <a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}"
                        class="page-pretitle flex items-center">
                        <svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z" />
                        </svg>
                        {{ __('Back to dashboard') }}
                    </a>
                    <h2 class="page-title mb-2">
                        {{ __('User Management') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <form class="lqd-generator-search-form group !mb-6 !px-5" onsubmit="return false;">
                <div class="input-icon w-full max-lg:bg-[#fff] max-lg:dark:bg-zinc-800">
                    <span class="input-icon-addon">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                            <path d="M21 21l-6 -6" />
                        </svg>
                    </span>
                    <input class="peer" type="search" id="searchInput" oninput="filterUsers()"
                        placeholder="{{ __('Search for users.') }}" aria-label="Search in website">
                </div>
            </form>
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>{{ __('User Management') }}</h4>
                    <a class="btn btn-primary" href="{{ route('dashboard.admin.users.create') }}">{{ __('Add New') }}</a>
                </div>
                <div id="table-default" class="card-table table-responsive">
                    <table id="userTable" class="table">
                        <thead>
                            <tr>
                                <th><button class="table-sort" data-sort="sort-name">{{ __('Name') }}</button></th>
                                <th><button class="table-sort" data-sort="sort-group">{{ __('Group') }}</button></th>
                                <th><button class="table-sort"
                                        data-sort="sort-remaining-words">{{ __('Words Left') }}</button></th>
                                <th><button class="table-sort"
                                        data-sort="sort-remaining-images">{{ __('Images Left') }}</button></th>
                                <th><button class="table-sort" data-sort="sort-country">{{ __('Country') }}</button></th>
                                <th><button class="table-sort" data-sort="sort-status">{{ __('Status') }}</button></th>
                                <th><button class="table-sort" data-sort="sort-date">{{ __('Created At') }}</button></th>
                                <th class="!text-center">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody align-middle text-heading">

                            <!-- TODO DEMO -->
                            @if ($app_is_not_demo)
                                @foreach ($users as $entry)
                                    <tr>
                                        <td class="sort-name">{{ $entry->fullName() }}</td>
                                        <td class="sort-group">{{ $entry->type }}</td>
                                        <td class="sort-remaining-words">{{ $entry->remaining_words }}</td>
                                        <td class="sort-remaining-images">{{ $entry->remaining_images }}</td>
                                        <td class="sort-country">{{ $entry->country }}</td>
                                        <td class="sort-status">{{ $entry->status == 1 ? __('Active') : __('Passive') }}
                                        </td>
                                        <td class="sort-date" data-date="{{ strtotime($entry->created_at) }}">
                                            <p class="m-0">{{ date('j.n.Y', strtotime($entry->created_at)) }}</p>
                                            <p class="m-0 text-muted">{{ date('H:i:s', strtotime($entry->created_at)) }}
                                            </p>
                                        </td>
                                        <td class="!text-end whitespace-nowrap">
                                            <a href="{{ route('dashboard.admin.users.finance', $entry->id) }}"
                                                class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white open-modal-link"
                                                title="{{ __('Finance Management') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                    <path d="M12 3v3m0 12v3" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('dashboard.admin.users.edit', $entry->id) }}"
                                                class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white"
                                                title="{{ __('Edit') }}">
                                                <svg width="13" height="12" viewBox="0 0 15 14" fill="none"
                                                    stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z"
                                                        stroke-width="1.25" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('dashboard.admin.users.delete', $entry->id) }}"
                                                onclick="return confirm('{{ __('Are you sure? This is permanent and will delete all documents related to user.') }}')"
                                                class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white"
                                                title="{{ __('Delete') }}">
                                                <svg width="10" height="10" viewBox="0 0 10 10"
                                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">User Informations are hidden in demo due to GDPR. See <a
                                            href="https://en.wikipedia.org/wiki/General_Data_Protection_Regulation"
                                            target="_blank">What is GDPR</a> </td>
                                </tr>
                                <tr>
                                    <td class="sort-name">John Doe</td>
                                    <td class="sort-group">User</td>
                                    <td class="sort-remaining-words">12.154</td>
                                    <td class="sort-remaining-images">940</td>
                                    <td class="sort-country">Hungary</td>
                                    <td class="sort-status">Active</td>
                                    <td class="sort-date" data-date="19-12-2022">
                                        <p class="m-0">19-12-2022</p>
                                        <p class="m-0 text-muted">19-12-2022</p>
                                    </td>
                                    <td class="!text-end whitespace-nowrap">
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white"
                                            title="{{ __('Finance Management') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                <path d="M12 3v3m0 12v3" />
                                            </svg>
                                        </a>
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white"
                                            title="{{ __('Edit') }}">
                                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none"
                                                stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z"
                                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white"
                                            title="{{ __('Delete') }}">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="sort-name">Patricia Foe</td>
                                    <td class="sort-group">User</td>
                                    <td class="sort-remaining-words">10.154</td>
                                    <td class="sort-remaining-images">120</td>
                                    <td class="sort-country">Albania</td>
                                    <td class="sort-status">Active</td>
                                    <td class="sort-date" data-date="19-12-2022">
                                        <p class="m-0">12-12-2022</p>
                                        <p class="m-0 text-muted">19-12-2022</p>
                                    </td>
                                    <td class="!text-end whitespace-nowrap">
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white"
                                            title="{{ __('Finance Management') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />
                                                <path d="M12 3v3m0 12v3" />
                                            </svg>
                                        </a>
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-[var(--tblr-primary)] hover:text-white"
                                            title="{{ __('Edit') }}">
                                            <svg width="13" height="12" viewBox="0 0 15 14" fill="none"
                                                stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.71875 2.43988L11.9688 5.58995M10.75 11.4963H14M4.25 13.0714L12.7812 4.80248C12.9946 4.59564 13.1639 4.35009 13.2794 4.07984C13.3949 3.8096 13.4543 3.51995 13.4543 3.22744C13.4543 2.93493 13.3949 2.64528 13.2794 2.37504C13.1639 2.10479 12.9946 1.85924 12.7812 1.6524C12.5679 1.44557 12.3145 1.28149 12.0357 1.16955C11.7569 1.05761 11.458 1 11.1562 1C10.8545 1 10.5556 1.05761 10.2768 1.16955C9.99799 1.28149 9.74465 1.44557 9.53125 1.6524L1 9.92135V13.0714H4.25Z"
                                                    stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <a onclick="return toastr.error('You cannot edit or remove user in demo mode!')"
                                            class="btn w-[36px] h-[36px] p-0 border hover:bg-red-500 hover:text-white"
                                            title="{{ __('Delete') }}">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M9.08789 1.74609L5.80664 5L9.08789 8.25391L8.26758 9.07422L4.98633 5.82031L1.73242 9.07422L0.912109 8.25391L4.16602 5L0.912109 1.74609L1.73242 0.925781L4.98633 4.17969L8.26758 0.925781L9.08789 1.74609Z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                    <div
                        class="flex items-center border-solid border-t border-r-0 border-b-0 border-l-0 border-[--tblr-border-color] px-[--tblr-card-cap-padding-x] py-[--tblr-card-cap-padding-y] [&_.rounded-md]:rounded-full">
                        {{-- <ul class="pagination m-0 ms-auto p-0"></ul> --}}
                        <div class="m-0 ms-auto p-0">{{ $users->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="/assets/js/panel/user.js"></script>
    <script>
        function filterUsers() {
            var input = document.getElementById('searchInput').value.toLowerCase();
            $.ajax({
                type: 'GET',
                url: '/dashboard/admin/users',
                data: {
                    search: input
                },
                success: function(data) {
                    $('#userTable tbody').html($(data).find('tbody').html());
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection
