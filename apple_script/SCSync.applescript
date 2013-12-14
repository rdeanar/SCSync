-- replace icon tutorial http://loekvandenouweland.com/index.php/2012/07/replacing-default-applescript-application-icon-with-a-custom-icns-file/

on run
	set projectDir to "SCSync"
	set authFile to "auth.txt"
	set serverAdress to "0.0.0.0:8080"
	
	tell application "Finder"
		activate
		
		set homePath to POSIX path of (home as Unicode text)
		set authFilePath to homePath & {projectDir, "/", authFile}
		set projectDirPath to homePath & {projectDir, "/"}
		
		tell application "Finder" to set authFileExists to exists my POSIX file authFilePath
		
		if authFileExists then --  auth file found, continue download
			
			set downloadScriptPath to homePath & {projectDir, "/get.php"}
			set dirToDownload to POSIX path of ((the target of the front window) as text)
			
			display dialog "What are you want to download (your stream or any other url)?" default answer "STREAM"
			set whatDownload to (text returned of result)
			
			display dialog "Enter limit (max 50)" default answer "50"
			set limit to (text returned of result)
			
			set commandText to "php " & {"\"", downloadScriptPath, "\"", " ", "\"", dirToDownload, "\"", " ", "\"", whatDownload, "\"", " ", "\"", limit, "\""}
			display dialog "Will download: " & whatDownload & " (limit: " & limit & ") to " & dirToDownload & ". OK?"
			
			tell application "Terminal" to activate
			tell application "Terminal"
				activate
				if it is running then
					tell application "System Events" to keystroke "t" using command down
					repeat while contents of selected tab of window 1 starts with linefeed
						delay 0.01
					end repeat
				end if
				do script commandText in front window
				-- do script "php -r \" sleep(4); echo 'ECHO'; \"" in front window
				do script "osascript -e 'tell application \"Finder\" to activate'" in front window
			end tell
			
			
		else
			-- no auth file exists. Require Auth
			tell application "Terminal" to activate
			tell application "Terminal"
				activate
				if it is running then
					tell application "System Events" to keystroke "t" using command down
					repeat while contents of selected tab of window 1 starts with linefeed
						delay 0.01
					end repeat
				end if
				do script "cd " & projectDirPath & "; php -S " & serverAdress in front window
			end tell
			tell application "Safari"
				activate
				delay 1
				open location "http://" & serverAdress
			end tell
		end if
		
	end tell
	
end run