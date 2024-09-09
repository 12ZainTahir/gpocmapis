<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;


class FileController extends Controller
{
  
  public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimetypes:text/plain,application/hl7-v2|max:2048',
    ]);
    
    // Get the original filename
    $originalName = $request->file('file')->getClientOriginalName();
    
    // Define the public directory path where you want to store the file
    $path = $request->file('file')->move(public_path('request'), $originalName);
    
    // Save file metadata in the database
    $file = File::create([
        'filename' => $originalName,
        'path' => 'request/' . $originalName, // Adjust path for public directory
    ]);

    return response()->json([
        'message' => 'File uploaded successfully',
        'file' => $file,
    ], 201);
}

   


public function test(Request $request) {
    return response()->json([
        'message' => 'File uploaded succlly',
        'file' => 'Test',
    ], 201);
}

  
public function ListFiles() {
    // Define the path to the 'public/request' directory
    $directoryPath = public_path('request');

    // Get all files in the 'public/request' directory
    $files = scandir($directoryPath);

    // Prepare an array to store the full URLs of each file
    $fileUrls = [];

    // Loop through the files and generate URLs
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') { // Skip the special directories '.' and '..'
            $fileUrls[] = url('request/' . $file); // Generate the full URL for each file
            
           DB::table('files')
    ->where('filename', $file) 
    ->update(['downloaded' => 1]); 
        
        break;
                
        }
    }

    // Return the list of file URLs as a JSON response
    return response()->json($fileUrls);
}




   
    public function deleteAllFiles()
{
    // Define the path to the 'public/request' directory
    $directoryPath = public_path('request');

    // Get all files in the 'public/request' directory
    $files = glob($directoryPath . '/*'); // Get all files in the directory
    
    
    // Loop through and delete each file
    foreach ($files as $file) {
        
        
        
    $myfilename = str_replace("https://gpocm.ocmsoftware.ie/public/request/", "", $file);
    $myfilename = str_replace("/home/ocmsoftware/public_html/gpocm.ocmsoftware.ie/public/request/", "", $myfilename);
    
      $rowsAffected = DB::table('files')
    ->where('filename', $myfilename)
    ->where('downloaded', '1')
    ->update(['deleted' => 1]);

        if ($rowsAffected > 0) {
            echo "$rowsAffected row(s) updated.\n";
            // Proceed with file deletion
            if (is_file($file)) {
                unlink($file); // Delete the file
                echo "File deleted.\n";
            } else {
                echo "File does not exist.\n";
            }
        } else {
            echo "No rows were updated.\n";
        }


    }

    return response()->json(['message' => 'All files deleted successfully.'], 200);
}




 public function uploadresultfile(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimetypes:text/plain,application/hl7-v2|max:2048',
    ]);
    
    // Get the original filename
    $originalName = $request->file('file')->getClientOriginalName();
    
    // Define the public directory path where you want to store the file
    $path = $request->file('file')->move(public_path('result'), $originalName);
    
    // Save file metadata in the database
    $file = File::create([
        'filename' => $originalName,
        'path' => 'result/' . $originalName, // Adjust path for public directory
    ]);

    return response()->json([
        'message' => 'File uploaded successfully',
        'file' => $file,
    ], 201);
}

  
  
public function ListResultFiles() {
    // Define the path to the 'public/request' directory
    $directoryPath = public_path('result');

    // Get all files in the 'public/request' directory
    $files = scandir($directoryPath);

    // Prepare an array to store the full URLs of each file
    $fileUrls = [];

    // Loop through the files and generate URLs
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') { // Skip the special directories '.' and '..'
            $fileUrls[] = url('result/' . $file); // Generate the full URL for each file
            
           DB::table('files')
    ->where('filename', $file) 
    ->update(['downloaded' => 1]); 

                
        }
    }

    // Return the list of file URLs as a JSON response
    return response()->json($fileUrls);
}








public function deleteresultfile()
{
    // Define the path to the 'public/request' directory
    $directoryPath = public_path('result');

    // Get all files in the 'public/request' directory
    $files = glob($directoryPath . '/*'); // Get all files in the directory
    
    
    // Loop through and delete each file
    foreach ($files as $file) {
        
        
        
    $myfilename = str_replace("https://gpocm.ocmsoftware.ie/public/result/", "", $file);
    $myfilename = str_replace("/home/ocmsoftware/public_html/gpocm.ocmsoftware.ie/public/result/", "", $myfilename);
    
      $rowsAffected = DB::table('files')
    ->where('filename', $myfilename)
    ->where('downloaded', '1')
    ->update(['deleted' => 1]);

        if ($rowsAffected > 0) {
            echo "$rowsAffected row(s) updated.\n";
            // Proceed with file deletion
            if (is_file($file)) {
                unlink($file); // Delete the file
                echo "File deleted.\n";
            } else {
                echo "File does not exist.\n";
            }
        } else {
            echo "No rows were updated.\n";
        }


    }

    return response()->json(['message' => 'All files deleted successfully.'], 200);
}



    
}
