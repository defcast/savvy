<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>MPEG-DASH Player - Live Video Streaming | Wowza Media Systems</title>

    <script language="javascript">AC_FL_RunContent = 0;</script>

    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/wowza.css" type="text/css" />

    <!-- Libraries -->

    <!-- DASH-AVC/265 reference implementation -->
    <script src="js/shaka-player.js"></script>

    <!-- Framework CSS -->
    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="css/wowza.css" type="text/css" />

    <script>
        function supports_media_source()
        {
            "use strict";
            var hasWebKit = (window.WebKitMediaSource !== null && window.WebKitMediaSource !== undefined),
                hasMediaSource = (window.MediaSource !== null && window.MediaSource !== undefined);
            return (hasWebKit || hasMediaSource);
        }
    </script>

</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="span-18">
            <h1>Live Video Streaming</h1>
            <h2>MPEG-DASH Player</h2>
        </div>
        <div class="span-6 last">
            <a href="https://www.wowza.com"><img src="img/wowza-logo_1024.png" class="logo" style="height:72px;width:205px" /></a>
        </div>
        <hr class="heading">
        <!-- END HEADER -->
        <!-- EXAMPLE PLAYER: WIDTH of this player should be 630px, height will vary depending on the example-->
        <div class="span-16">
            <div id="notsupported" style="display:none">
                <br/>
                <br/>
                <br/>
                <h2><b>The MediaSource API is not supported by this browser</b></h2>
                <br/>
                <h3>Please view in a browser that supports the MediaSource API, such as Google Chrome.</h3>
                <br/>
                <br/>
            </div>
            <div id="supported" style="display:none">
                <div>
                    <style>
                        video {
                            background-color: #000000;
                        }
                    </style>
                    <video id="videoObj" x-webkit-airplay="allow" controls alt="Example File" width="630" height="354" autoplay></video>
                </div>
                <table>
			<!--
                    <tr>
                        <td>
                            <button id="playObj" type="button" style="width:50px" onclick="JavaScript:playControl()" disabled="disabled">Pause</button>
                        </td>
                    </tr>
			-->
                    <tr>
                        <td align="right">
                            <b>Stream:</b>
                        </td>
                        <td>
                            <input id="connectStr" size = "56" type="text" placeholder="" value="http://localhost:1935/live/myStream/manifest.mpd"/>
                            <button id="connectObj" type="button" style="width:80px" onclick="JavaScript:connect()">Start</button>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">
                            <b>Status:</b>
                        </td>
                        <td>
                            <label id="statusStr" size = "100" type="text" placeholder="" value="">Disconnected</label>
                        </td>
                    </tr>
                </table>
            </div>
			<div id="debug_log" style="height: 425px; width: 630px; overflow: auto; clear: both;">
			</div>
        <script>
            if ( supports_media_source() ) {
                supported.style.display="";
                videoObj.style.display="";
            }
            else {
                notsupported.style.display="";
            }
		var video;
		var player;
		var source; 
		var estimator;

            function connect()
            {
                if(connectObj.textContent == "Stop") 
			{
			dashStop();
			connectObj.textContent = "Start";
			statusStr.textContent = "Disconnected";
                	}
                else {

                        connectObj.textContent = "Stop";
                        statusStr.textContent = "Playing";
                        if ( video == null )
                        { video = document.querySelector("video"); }

                        if ( player == null )
                        { player = new shaka.player.Player(video); }

                        // Attach the player to the window so that it can be easily debugged.
                        window.player = player;

                        // Listen for errors from the Player.
                        player.addEventListener('error', failed );

                        // Construct a DashVideoSource to represent the DASH manifest.
                        //var mpdUrl = 'http://turtle-tube.appspot.com/t/t2/dash.mpd';
                        if ( estimator != null )
			{ estimator=null; }
                        estimator = new shaka.util.EWMABandwidthEstimator();

                        if ( source != null )
                        { source = null; }

                        source = new shaka.player.DashVideoSource(connectStr.value, null, estimator);

                        // Load the source into the Player.
                        player.load(source);
                	}
            }

	function failed(e)
	{
	var done = false;
	if ( e.detail == 'Error: Network failure.' )
		{
		statusStr.textContent = 'Network Connection Failed.';
		done = true;
		}
        if ( e.detail.status!=200 && done == false )
                {
		switch ( e.detail.status )
			{
			case 404:
			statusStr.textContent = e.detail.url+' not found.';
			break;
			default:
	                statusStr.textContent = 'Error '+e.detail.status+' for '+e.detail.url;
			break;
                	}
		}
        }

	function dashStop()
	{
		if(player!=null)
		{
		player.unload();
		}
	connectObj.textContent = "Start";
	statusStr.textContent = "Disconnected";
	}

            </script>
        </div>
        <!-- SIDEBAR -->
        <div class="span-7 prepend-1 last">
            <h3>Description</h3>
            <p>This example contains source code for an MPEG-DASH player using the Shaka Player package from the <a href="https://github.com/google/shaka-player">Shaka Player project</a>. It will play MPEG-DASH single and adaptive bitrate live MP4 streams.</p> 
            <p><strong>Warning:</strong> You may experience inconsistent playback using this third-party beta DASH test player.</p>
            <h3>Installation</h3>
            <p>In the <strong>/examples/LiveVideoStreaming</strong> directory:<br>
            <ul>
                <li>LINUX<br>
                    Run <strong>./installall.sh</strong>
                <li>WINDOWS 7 / WINDOWS 8<br>
                    Right-click <strong>installall.bat</strong> and then select <strong>Run as administrator</strong>
                <li>WINDOWS SERVER<br>
                    Double-click the <strong>installall.bat</strong> file                 
                <li>OS X<br>
                    Double-click the <strong>installall.command</strong> file
                </ul>
            <h3>Instructions</h3>
            <ol>
                <li>Read the Tutorials below.
                <li>Make sure that the URL in the <strong>Stream</strong> field is correct.
                <li>Click the <strong>Connect</strong> button.
            </ol>
            <h3>Tutorials</h3>
            <ul>
                <li><a href="https://www.wowza.com/docs/how-to-do-mpeg-dash-streaming">How to do MPEG-DASH streaming</a></li>
                <li><a href="https://www.wowza.com/docs/how-to-play-your-first-live-stream-video-tutorial">How to play your first live stream (video tutorial)</a>
                <li><a href="https://www.wowza.com/docs/how-to-publish-and-play-a-live-stream-mpeg-ts-based-encoder">How to publish and play a live stream (MPEG-TS-based encoder)</a>
                <li><a href="https://www.wowza.com/docs/how-to-re-stream-video-from-an-ip-camera-rtsp-rtp-re-streaming">How to re-stream video from an IP camera (RTSP/RTP re-streaming)</a>
                <li><a href="https://www.wowza.com/docs/how-to-set-up-live-streaming-using-a-native-rtp-encoder-with-sdp-file">How to set up live streaming using a native RTP encoder with SDP file</a>
                <li><a href="https://www.wowza.com/docs/how-to-set-up-live-streaming-using-an-rtmp-based-encoder">How to set up live streaming using an RTMP-based encoder</a>
                <li><a href="https://www.wowza.com/docs/how-to-set-up-live-streaming-using-an-rtsp-rtp-based-encoder">How to set up live streaming using an RTSP/RTP-based encoder</a>
            </ul>
			<h3>Additional Resources</h3>
            <ul>
                <li><a href="https://www.wowza.com/docs/live-streaming-and-encoders">Live Streaming and Encoders Articles</a>
                <li><a href="https://www.wowza.com/community/spaces/13/live-streaming-and-encoders.html">Live Streaming and Encoders Forum</a>
                <li><a href="https://www.wowza.com/docs/record-live-streams">Recording Live Streams</a>
            </ul>
        </div>
        <!-- FOOTER -->
        <div class="span-24">
            <hr class="heading">
            <div class="span-1">
            	<img src="img/icon-company.png" width="32" height="32" />
            </div>
            <div class="span-23 last copyright">
                &nbsp;&#169;&nbsp;2007&ndash;2017 Wowza Media Systems&#8482;, LLC. All rights reserved.
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
</body>
</html>
