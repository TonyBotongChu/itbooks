@extends('layouts.frame')

@section('title', '样书申请详情')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">申请情况</div>
                    <div class="panel-body">
                        <p><strong>申请书目:</strong> {{$bookreq->book->name}}</p>
                        <p><strong>申请用户:</strong> {{$bookreq->user->username}}</p>
                        <p><strong>发起时间:</strong> {{$bookreq->created_at}}</p>
                        <p><strong>审批状态:</strong>
                            <span style="color: {{$bookreq->status==0?'#777':($bookreq->status==1?'#4E4':'#E44')}}">
                                {{$bookreq->status==0?'审核中':($bookreq->status==1?'已通过':'未通过')}}
                            </span>
                        </p>
                    </div>
                </div>


                @if($bookreq->status==1)
                    <div class="panel panel-default">
                        <div class="panel-heading">物流详情</div>
                        <div class="panel-body">
                            当审批通过后，这里将会显示当前样书的物流状态。
                        </div>
                    </div>
                @endif

            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">图书简介</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <p><strong>{{$bookreq->book->name}}</strong></p>
                            <div class="col-md-6 col-xs-12">
                                <img src="{{ url_file_exists("http://www.tup.com.cn/upload/bigbookimg/".$bookreq->book->product_number.".jpg")?"http://www.tup.com.cn/upload/bigbookimg/".$bookreq->book->product_number.".jpg":"/test_images/404.jpg" }}" class="img-responsive" alt="" style="width: 100%;">

                            </div>
                            <div class="col-md-6 col-xs-12">
                                <ul>
                                    <li>作者: {{$bookreq->book->authors}}</li>
                                    <li>ISBN号: {{$bookreq->book->isbn}}</li>
                                    <li>定价: {{$bookreq->book->price}}</li>
                                    <li>类别: {{$bookreq->book->type==0?"其他图书":($bookreq->book->type==1?"教辅":"非教辅")}}</li>
                                    <li>出版时间: {{date('Y-m-d', strtotime($bookreq->book->publish_time))}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <a href="{{route('bookreq.record')}}">
                    <button class="btn btn-primary">返回列表</button>
                </a>
            </div>
            @if($bookreq->status==0)
                <div class="col-xs-4">
                    {!! Form::open(['route'=>['bookreq.destroy', $bookreq->id], 'method'=>'DELETE']) !!}
                    {!! Form::submit('删除申请', ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            @endif
        </div>


    </div>

@endsection