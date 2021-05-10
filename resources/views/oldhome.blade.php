@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="">
                    <div class="nav-item dropdown">
                        <a id="leagueBtn" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            League
                        </a>

                        <div class="dropdown-menu league-menu" aria-labelledby="leagueBtn">
                            <a class="dropdown-item" href="#">
                                {{ __('Admin') }}
                            </a>

                            <a class="dropdown-item" href="#">
                                {{ __('Logout') }}
                            </a>
                            
                        </div>
                    </div>

                    <div class="">
                        <nav class="nav justify-content-center">
                            <a class="nav-link" href="#">Matches</a>
                            <span class="nav-link">Standings</span>
                            <a class="nav-link" href="{{ route('goals') }}">Goals</a>
                            <a class="nav-link" href="#">Assists</a>
                        </nav>
                    </div>

                    <div class="nav-item dropdown mb-2">
                        <a id="seasonBtn" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Season
                        </a>

                        <div class="dropdown-menu season-menu" aria-labelledby="seasonBtn">
                            <a class="dropdown-item" href="#">
                                {{ __('Admin') }}
                            </a>

                            <a class="dropdown-item" href="#">
                                {{ __('Logout') }}
                            </a>
                            
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm font-weight-light">
                            <thead>
                                <tr>
                                    <td scope="col">#</td>
                                    <td scope="col" class="col">Team</td>
                                    <td scope="col">MP</td>
                                    <td scope="col">W</td>
                                    <td scope="col">D</td>
                                    <td scope="col">L</td>
                                    <th scope="col">Pts</th>
                                    <td scope="col">GS</td>
                                    <td scope="col">GC</td>
                                    <td scope="col">GD</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">1</td>
                                    <td>Sit</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <th>30</th>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td scope="row">2</td>
                                    <td>Adipisicing</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <th>30</th>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td scope="row">3</td>
                                    <td>Hic</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                    <th>30</th>
                                    <td>30</td>
                                    <td>30</td>
                                    <td>30</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(".season-menu a").click(function(){
            $("#seasonBtn:first-child").html($(this).text());
        });
        $(".league-menu a").click(function(){
            $("#leagueBtn:first-child").html($(this).text());
        });
    </script>
@endsection
