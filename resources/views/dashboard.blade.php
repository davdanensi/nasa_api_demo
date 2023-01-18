<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- For Demo Purpose -->
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 mx-auto">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                <!-- Date Picker Input -->
                                <div class="form-group mb-4">
                                    <div class="datepicker date input-group p-0 shadow-sm">
                                        <input type="text" placeholder="Select Start Date" class="form-control" id="startDate">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div><!-- DEnd ate Picker Input -->

                                <!-- Date Picker Input -->
                                <div class="form-group mb-4">
                                    <div class="datepicker date input-group p-0 shadow-sm">
                                        <input type="text" placeholder="Select End Date" class="form-control" id="endDate">
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div><!-- DEnd ate Picker Input -->

                                <!-- For Demo Purpose -->
                                <div class="text-center">
                                    <button id="submit" class="btn btn-primary btn-sm px-4 rounded-pill text-uppercase font-weight-bold shadow-sm">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="chartComponent" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3 d-none">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- For Demo Purpose -->
                    <div class="container">
                        <div class="row">
                            <table class="table table-primary">
                                <thead class="table-light">
                                    <tr>
                                        <th colspan="2">Result:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-success">
                                        <th>Fastest Astroid Id</th>
                                        <td id="fastest_aseroid_id"></td>
                                        <th>Speed</th>
                                        <td id="fastest_aseroid"></td>
                                    </tr>
                                    <tr class="table-info">
                                        <th>Closest Astroid Id</th>
                                        <td id="closest_aseroid_id"></td>
                                        <th>Distance</th>
                                        <td id="closest_aseroid"></td>
                                    </tr>
                                    <tr>
                                        <th>Avarage Size Aseroid</th>
                                        <td colspan="3" id="avarage_size_aseroid"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div>
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>