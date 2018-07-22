<?php

namespace App\Http\Controllers;

use App\User;
use Image;
use App\ImageLike;
use App\GalleryImage;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.

     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            

       return view('gallery');
    }


    public function getImages()
    {

        $images = GalleryImage::with('user')
                            ->with(['likes' => function ($query) {
                                        $query->whereNull('deleted_at');
                                        $query->where('user_id', auth()->user()->id);

                            }])->get(); 
    
        $data = $images->map(function(GalleryImage $image)
        {

            $image['likedByMe'] = $image->likes->count() == 0 ? false : true;
            $image['ImagelikesCount'] = ImageLike::where('image_id', $image->id)->get()->count();

            return $image;
        });

        return response()->json($data); 
    }

    public function isLikedByMe($id)
    {
        if (ImageLike::whereUserId(auth()->user()->id)
                 ->whereImageId($id)->exists()){
            return 'true';
        }
        return 'false';
    }

    public function like(GalleryImage $image, Request $request)
    {
        $existing_like = ImageLike::withTrashed()->whereImageId($image->id)->whereUserId(auth()->id())->first();

        if (is_null($existing_like)) {
            ImageLike::create([
                'image_id' => $image->id,
                'user_id' => auth()->user()->id
            ]);


        } else {
            if (is_null($existing_like->deleted_at)) {
                $existing_like->delete();
            } else {
                $existing_like->restore();
            }
        }
    }



    public function uploadimage(Request $request)
    {

        $data = request()->validate([
         'image_title' => 'required|max:100'
        ]);

         if($request->hasFile('gallery_name')){
            $imagename = $data['image_title'];
            $postimage = $request->file('gallery_name');
            $filename = time() . '.' . $postimage->getClientOriginalExtension();
            Image::make($postimage)->resize(500, 400)->save( public_path('/uploads/gallery/' . $filename ) );
            $gallery = new GalleryImage();
            $gallery->user_id = auth()->user()->id;
            $gallery->image_title = $imagename;
            $gallery->file_name =  $filename;
            $gallery->save();


            return redirect('gallery');
        }

        if(!$user)
        {
            return redirect('/home');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    // public function getImages(GalleryImage $galleryimage)
    // {
    //             $user = GalleryImage::with('user')
    //                     ->orderBy('created_at', 'desc')
    //                     ->get();

    //             return $image->with($user);

    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
