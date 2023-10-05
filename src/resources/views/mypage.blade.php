@extends('layouts.layouts')

@section('title','MyPage')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('content')
    <div class="container">
        <h1>ようこそ&emsp;{{ Auth::user()->name }}さん！</h1>
        @if (session('message'))
            <div class="alert-success">
                {{ session('message') }}
            </div>
        @endif
        @foreach ($errors->all() as $error)
            <li class="error">{{$error}}</li>
        @endforeach
        @if(Auth::user()->role > 9)
            <h2>当日予約状況</h2>
            <div class="qr-area">
                @foreach($representatives as $representative)
                <div class="qr-box">
                    <p>{{$representative->shop->name}}</p>
                    <p>{{QrCode::generate(route('representativeReserve',[$representative->shop_id]))}}</p>
                </div>
                @endforeach
            </div>
        @endif
        <div class="container-area">
            <div class="reserve-wrap">
                <h2>予約状況</h2>
                <div class="reserve-wrap__item">
                    @foreach($reserves as $key => $reserve)
                        <div class="reserve-confirmation">
                            <div class="reserve-confirmation-area  {{$reserve->id}}">
                                <div class="reserve-confirmation-area-head">
                                    <img src="{{ asset('svg/時計.svg')}}" alt="" id="clock">
                                    <span id="reserve-num">予約{{$loop->iteration}}</span>
                                    @if($reserve->date != \Carbon\Carbon::now()->format('Y-m-d'))
                                        <form action="{{route('reserveDelete')}}" method="post">
                                            @method('delete')
                                            @csrf
                                            <input type="hidden" value="{{$reserve->id}}" name="id">
                                            <button class="button" type="submit">予約取り消し</button>
                                        </form>
                                        <form class="update-button" id="update-button_{{$key}}">
                                            <input type="hidden" value="{{$reserve->id}}" name="id">
                                            <button class="button" type="submit">予約更新</button>
                                        </form>
                                    @endif
                                </div>
                                <p><label>shop</label>&emsp;<span>{{$reserve->shop->name}}</span></p>
                                <p><label>date</label>&emsp;<span id="output-date">{{$reserve->date}}</span></p>
                                <p><label>time</label>&emsp;<span id="output-time">{{$reserve->time}}</span></p>
                                <p><label>number</label>&emsp;<span id="output-number">{{$reserve->hc}}</span></p>
                                @if($reserve->recommendation>0)
                                <p><label>事前決済</label>&emsp;<span>￥{{$reserve->recommendation}}</span></p>
                                @else
                                <form action="{{route('recommendationAdd')}}" method="get">
                                    <input type="hidden" name="id" value="{{$reserve->id}}">
                                    <button class="button" type="submit">おすすめコースの事前決済に進む</button>
                                </form>
                                @endif
                            </div>
                            <div class="reserve-confirmation-area {{$reserve->id}} none">
                                <div class="reserve-confirmation-area-head">
                                    <img src="{{ asset('svg/時計.svg')}}" alt="" id="clock">
                                    <span id="reserve-num">予約{{$loop->iteration}}</span>
                                    <form class="cancel-button">
                                        <input type="hidden" value="{{$reserve->id}}" name="id">
                                        <button class="button" type="submit">キャンセル</button>
                                    </form>
                                </div>
                                <form action="{{route('reserveUpdate')}}" method="post">
                                    @method('put')
                                    @csrf
                                    <input type="hidden" value="{{$reserve->id}}" name="id" id="reserve-id_{{$key}}">
                                    <input type="hidden" value="{{$reserve->shop->id}}" name="shop_id" id="shop_id_{{$key}}">
                                    <input type="hidden" name="remaining" class="remaining_{{$key}}" value="">
                                    <p><label>shop</label>&emsp;<span>{{$reserve->shop->name}}</span></p>
                                    <p><label>date</label>&emsp;<input type="date" name="date" id="input-date_{{$key}}" class="input-date" value="{{$reserve->date}}"></p>
                                    <p><label>time</label>&emsp;<input type="time" name="time" id="input-time_{{$key}}" class="input-time" value="{{$reserve->time}}"></p>
                                    <p><label>number</label>&emsp;<input type="number" min="0" name="hc" id="input-number_{{$key}}" value="{{$reserve->hc}}" class="input-number"></p>
                                    <div class="confirm-button-area">
                                        <button id="confirm-button_{{$key}}" type="submit" class="confirm-button">確定</button>
                                        <p id="date-alert_{{$key}}" class="none">変更可能日時は翌日以降です</p>
                                        <p id="time-alert_{{$key}}" class="none">予約可能時間は11：00～22：00です</p>
                                    </div>
                                    <p class="reserve-seat-change-p none" id="reserve-seat-change-p_{{$key}}">ご希望の日時の予約可能席数は、<span class="remaining_{{$key}}" id="remaining_{{$key}}"></span>席です</p>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="shop-wrap">
                <h2>お気に入り店舗</h2>
                <div class="shop-wrap-area">
                @foreach($shops as $shop)
                    <div class="shop-wrap__item delete{{$shop->shop->id}}" href="">
                        <img src="{{asset($shop->shop->path)}}" alt="店舗画像" class="shop-wrap__item-eyecatch">
                        <div class="shop-wrap__item-content">
                            <h2>{{$shop->shop->name}}</h2>
                            <div>
                                <p class="shop-wrap__item-content-tag">#{{$shop->shop->area}}</p>
                                <p class="shop-wrap__item-content-tag">#{{$shop->shop->category}}</p>
                            </div>
                            <div class="shop-wrap__item-bottom">
                                <form action="{{route('detail',['id'=>$shop->shop->id])}}" method="get" name="id">
                                    <button class="detail">詳しく見る</button>
                                </form>
                                <form class="favoriteDelete">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="shop_id" value="{{$shop->shop->id}}">
                                    <button type="submit">
                                    <img src="{{ asset('svg/red.svg')}}" alt="お気に入り" class="heart">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $("[name='csrf-token']").attr("content") },
        })
        $('.favoriteDelete').on('submit', function(event){
            event.preventDefault();
            const user_id=$(this).find('input[name="user_id"]').val();
            const shop_id=$(this).find('input[name="shop_id"]').val();
            $.ajax({
                url: "{{ route('favoriteDelete') }}",
                method: "delete",
                data: {user_id:user_id,shop_id:shop_id},
                dataType: "json",
            }).done(function(res){
                $('.delete'+res.shop_id).addClass('none');
            }).faile(function(){
                alert('通信の失敗をしました');
            });
        });

        $(function() {
            $('.cancel-button').on('submit', function(event){
            event.preventDefault();
            const reserve_id=$(this).find('input[name="id"]').val();
            $('.'+reserve_id).toggleClass('none');
            });
            });



    $(function() {
    function updateReserve(id) {

        var date = $('#input-date_' + id).val();
        var originTime = $('#input-time_' + id).val().trim();
        var timeParts = originTime.split(':');
        var time = timeParts[0] + ':' + timeParts[1];
        var shop_id = $('#shop_id_' + id).val();
        var reserve_id = $('#reserve-id_' + id).val();
        var token = $('input[name="_token"]').val();

        console.log(reserve_id);

        if (date && time) {
            $.ajax({
                url:"{{ route('reserveSeatUpdate') }}",
                method: 'post',
                data: {
                    date: date,
                    time: time,
                    reserve_id:reserve_id,
                    shop_id: shop_id,
                    _token: $('input[name="_token"]').val()
                },
                dataType: "json",
            }).done(function(res){
                $('.remaining_' + id).text(res.remaining);
                $('input[name="remaining"]').val(res.remaining);
                var time = res.time;
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                var selectedDate = new Date(date);
                selectedDate.setHours(0, 0, 0, 0);
                if(selectedDate <= today){
                    $('#reserve-seat-change-p_' + id).addClass('none');
                    $('#confirm-button_' + id).addClass('none');
                    $('#date-alert_' + id).removeClass('none');
                    $('#time-alert_' + id).addClass('none');
                }
                else if (time >= '11:00' && time <= '22:00') {
                    $('#reserve-seat-change-p_' + id).removeClass('none');
                    $('#confirm-button_' + id).removeClass('none');
                    $('#date-alert_' + id).addClass('none');
                    $('#time-alert_' + id).addClass('none');
                }else{
                    $('#reserve-seat-change-p_' + id).addClass('none');
                    $('#confirm-button_' + id).addClass('none');
                    $('#time-alert_' + id).removeClass('none');
                    $('#date-alert_' + id).addClass('none');
                }
            }).fail(function(jqXHR, textStatus, errorThrown){
                alert('通信の失敗をしました: ' + textStatus + ', ' + errorThrown);
            });
        }
    }

    $('[id^=update-button_]').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('id').split('_')[1];
        const reserve_id=$(this).find('input[name="id"]').val();
        $('.'+reserve_id).toggleClass('none');
        $('#input-number_' + id).val(0);
        updateReserve(id);
    });

    $('[id^=input-date], [id^=input-time]').on('change', function() {
        var id = this.id.split('_')[1];
        $('#input-number_' + id).val(0);
        $('#reserve-seat-p_' + id).addClass('none');
        updateReserve(id);
    });
    });
    </script>

@endsection