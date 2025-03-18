<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\ModelConst;
use App\Models\User;
use App\Mail\NotifyApproval;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index_pending()
    {
        $bookings = Booking::where('doc_status', Booking::STATUS_PENDING)
                           ->where('doc_state', ModelConst::STATE_PROCESSING)
                        //    ->with('bookingRooms')
                           ->get();

        $bookingrooms = BookingRoom::all();
    
        $attrreviewConfig = Booking::getArrtibuteOptions('doc_status');
        $reviewConfig = Booking::getArrtibuteOptions('review_status');

        
        
        return view('review.index', compact('bookings', 'bookingrooms', 'reviewConfig' , 'attrreviewConfig'));
    }

    public function index_success()
    {
        $bookings = Booking::where('doc_status', Booking::STATUS_APPROVED)
                           ->where('doc_state', ModelConst::STATE_COMPLETED)
                        //    ->with('bookingRooms')
                           ->get();
 
        $bookingrooms = BookingRoom::all();

        $attrreviewConfig = Booking::getArrtibuteOptions('doc_status');
        $reviewConfig = Booking::getArrtibuteOptions('review_status');

        return view('review.indexsuccess', compact('bookings', 'bookingrooms', 'reviewConfig' , 'attrreviewConfig'));
    }

    public function index_approved()
    {
        return view('review.index', compact(
            Booking::getBookingList(
                Booking::STATUS['APPROVED'],
                Booking::STATE['COMPLETED']
            )
        ));


    }
    public function index_rejected()
    {
        return view('review.index', compact(
            Booking::getBookingList(
                Booking::STATUS['REJECTED'],
                Booking::STATE['COMPLETED']
            )
        ));
    }

    public function index_cancelled()
    {
        return view('review.index', compact(
            Booking::getBookingList(
                Booking::STATUS['CANCELLED'],
                Booking::STATE['COMPLETED']
            )
        ));
    }

    public function edit($id)
    {
        $bookinggg = Booking::find($id);
        $bookingrooms = BookingRoom::where('booking_id', $id)->get();
        return view('review.edit', compact('bookinggg', 'bookingrooms'));
    }

    // public function edit($id)
    // {
    //     $booking = Booking::find($id);
    //     $bookingrooms = BookingRoom::where('booking_id', $id)->get();
    //     return view('review.edit', compact('booking', 'bookingrooms'));
    // }

    // public function approve(){
    //     // $bookings = Booking::all()->where(['doc_status' => '1' , 'doc_state'=> '1']);
    //     $bookings = Booking::all();
    //     $bookingrooms = BookingRoom::all();

    //     return view('review.approvel', compact('bookings' , 'bookingrooms'));
    // }

}