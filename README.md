SCSync
======

Download anything from SoundCloud in one click

Video demonstration: https://www.youtube.com/watch?v=wtbL4OtdYCY

Installation and use
------

1. Open Terminal app;
2. Type "cd ~/";
3. Type "git clone --recursive https://github.com/rdeanar/SCSync.git";
4. Wait until the repository will be cloned to your home directory;
5. Open directory "apple_script" (~/SCSync/apple_script);
6. Move SCSync.app to your toolbar in Finder app with pressed Cmd button;
7. Run the app by clicking on the icon in toolbar;
8. In opened Safari tab click on authorize link and follow instructions to get auth for SCSync;
9. After you got message about successful authorization, close Safari tab and Terminal app tab;
10. Open any directory in Finder which you want to use to download your tracks into and click again on the app icon into Finder toolbar;
11. When you click on the app icon several wizard dialogs will open. After you answer all questions (e.g. what you want to download and tracks count) will be opened Terminal app and you will see progress of download;
12. When your download will be finished, you will see Finder window with all downloaded tracks.
13. Profit!


if you've already made clone without "--recursive" parameter, you can run this commands to clone submodule of php implementation of soundcloud api:
git submodule init
git submodule update
