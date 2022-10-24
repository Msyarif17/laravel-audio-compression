<?php

namespace App\Http\Controllers;

use FFMpeg\FFMpeg;
use ErrorException;
use FFMpeg\Format\Audio\Aac;
use Illuminate\Http\Request;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;

class KompresiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kompresi.index');
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
    //     $ffmpeg = FFMpeg::create(array(
    //         'ffmpeg.binaries'  => '/opt/local/ffmpeg/bin/ffmpeg',
    //         'ffprobe.binaries' => '/opt/local/ffmpeg/bin/ffprobe',
    //         'timeout'          => 3600, // The timeout for the underlying process
    //         'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
    //     ), $logger);
    //     $ffmpeg
    // ->setKiloBitrate(1000)
    // ->setAudioChannels(2)
    // ->setAudioKiloBitrate(256);
        // $lowBitrate = (new Aac)->setKiloBitrate(250);
        // $midBitrate = (new X264)->setKiloBitrate(500);
        // $highBitrate = (new X264)->setKiloBitrate(1000);
        // $superBitrate = (new X264)->setKiloBitrate(1500);

        // FFMpeg::open($request->file('audio'))
        //         ->exportForHLS()
        //         ->addFormat($midBitrate)
        //         ->toDisk('download')
        //         ->save($request->file('audio')->getClientOriginalName());
        $rand = rand(1,10000);
        $name = $rand.".".$request->file('audio')->getClientOriginalExtension();
        

        $request->file('audio')->storeAs('uploaded',$name);
        $audioPath = storage_path('app\\uploaded\\'.$name);
        $audioDownload = public_path('compressed\\compressed-'.$name);
        try{
            // $process = Process::fromShellCommandline("whoami", null, ['Path' => 'G:/ffmpeg/bin/']);

            // try {
            //     $process->mustRun(null, ['Path' => 'G:/ffmpeg/bin/']);

            //     $process->getOutput();
            // } catch (ProcessFailedException $exception) {
            //     return $exception->getMessage();
            // }
            // dd(shell_exec('ls'));
            shell_exec("ffmpeg -i ".$audioPath." -acodec libmp3lame -ab 64k -ac 1 -ar 11025 ".$audioDownload);

            $this->deleteAudio($audioPath);
        }catch(ErrorException $e){
            return $e;
        }
       
        return back()->with('download',array(asset('comp/compressed-'.$name),$request->file('audio')->getClientOriginalName()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    private function deleteAudio($name){
        File::delete($name);
    }
    public function getDownload($name){
        $file=public_path("comp/".$name);
        return Response::download($file);
    }

}
