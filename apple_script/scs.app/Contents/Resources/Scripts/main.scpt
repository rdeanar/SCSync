FasdUAS 1.101.10   ��   ��    k             l     ��  ��    � � replace icon tutorial http://loekvandenouweland.com/index.php/2012/07/replacing-default-applescript-application-icon-with-a-custom-icns-file/     � 	 	   r e p l a c e   i c o n   t u t o r i a l   h t t p : / / l o e k v a n d e n o u w e l a n d . c o m / i n d e x . p h p / 2 0 1 2 / 0 7 / r e p l a c i n g - d e f a u l t - a p p l e s c r i p t - a p p l i c a t i o n - i c o n - w i t h - a - c u s t o m - i c n s - f i l e /   
  
 l     ��������  ��  ��     ��  i         I     ������
�� .aevtoappnull  �   � ****��  ��    k           r         m        �    S C S y n c  o      ���� 0 
projectdir 
projectDir      r        m       �    a u t h . t x t  o      ���� 0 authfile authFile      r        m    	     � ! !  0 . 0 . 0 . 0 : 8 0 8 0  o      ���� 0 serveradress serverAdress   " # " l   ��������  ��  ��   #  $ % $ l   �� & '��   &  	display dialog msg    ' � ( ( & 	 d i s p l a y   d i a l o g   m s g %  ) * ) l   ��������  ��  ��   *  + , + O   � - . - k   � / /  0 1 0 I   ������
�� .miscactvnull��� ��� obj ��  ��   1  2 3 2 l   ��������  ��  ��   3  4 5 4 r     6 7 6 n     8 9 8 1    ��
�� 
psxp 9 l    :���� : c     ; < ; 1    ��
�� 
home < m    ��
�� 
utxt��  ��   7 o      ���� 0 homepath homePath 5  = > = r     ) ? @ ? b     ' A B A o     !���� 0 homepath homePath B J   ! & C C  D E D o   ! "���� 0 
projectdir 
projectDir E  F G F m   " # H H � I I  / G  J�� J o   # $���� 0 authfile authFile��   @ o      ���� 0 authfilepath authFilePath >  K L K r   * 2 M N M b   * 0 O P O o   * +���� 0 homepath homePath P J   + / Q Q  R S R o   + ,���� 0 
projectdir 
projectDir S  T�� T m   , - U U � V V  /��   N o      ����  0 projectdirpath projectDirPath L  W X W l  3 3��������  ��  ��   X  Y Z Y O  3 F [ \ [ r   7 E ] ^ ] I  7 A�� _��
�� .coredoexbool        obj  _ n  7 = ` a ` 4   8 =�� b
�� 
psxf b o   ; <���� 0 authfilepath authFilePath a  f   7 8��   ^ o      ����  0 authfileexists authFileExists \ m   3 4 c c�                                                                                  MACS  alis    t  Macintosh HD               Λ��H+     4
Finder.app                                                      %B�`|Y        ����  	                CoreServices    ΛŎ      �`D       4   1   0  6Macintosh HD:System: Library: CoreServices: Finder.app   
 F i n d e r . a p p    M a c i n t o s h   H D  &System/Library/CoreServices/Finder.app  / ��   Z  d e d l  G G��������  ��  ��   e  f g f Z   G� h i�� j h o   G J����  0 authfileexists authFileExists i k   Mi k k  l m l l  M M�� n o��   n * $  auth file found, continue download    o � p p H     a u t h   f i l e   f o u n d ,   c o n t i n u e   d o w n l o a d m  q r q l  M M��������  ��  ��   r  s t s r   M Y u v u b   M U w x w o   M N���� 0 homepath homePath x J   N T y y  z { z o   N O���� 0 
projectdir 
projectDir {  |�� | m   O R } } � ~ ~  / g e t . p h p��   v o      ���� (0 downloadscriptpath downloadScriptPath t   �  r   Z n � � � n   Z j � � � 1   h j��
�� 
psxp � l  Z h ����� � c   Z h � � � l  Z d ����� � l  Z d ����� � n   Z d � � � 1   ` d��
�� 
fvtg � l  Z ` ����� � 4  Z `�� �
�� 
cwin � m   ^ _���� ��  ��  ��  ��  ��  ��   � m   d g��
�� 
ctxt��  ��   � o      ���� 0 dirtodownload dirToDownload �  � � � l  o o��������  ��  ��   �  � � � I  o |�� � �
�� .sysodlogaskr        TEXT � m   o r � � � � � z W h a t   a r e   y o u   w a n t   t o   d o w n l o a d   ( y o u r   s t r e a m   o r   a n y   o t h e r   u r l ) ? � �� ���
�� 
dtxt � m   u x � � � � �  S T R E A M��   �  � � � r   } � � � � l  } � ����� � n   } � � � � 1   � ���
�� 
ttxt � 1   } ���
�� 
rslt��  ��   � o      ���� 0 whatdownload whatDownload �  � � � l  � ���������  ��  ��   �  � � � I  � ��� � �
�� .sysodlogaskr        TEXT � m   � � � � � � � ( E n t e r   l i m i t   ( m a x   5 0 ) � �� ���
�� 
dtxt � m   � � � � � � �  5 0��   �  � � � r   � � � � � l  � � ����� � n   � � � � � 1   � ���
�� 
ttxt � 1   � ���
�� 
rslt��  ��   � o      ���� 	0 limit   �  � � � l  � ���������  ��  ��   �  � � � r   � � � � � b   � � � � � m   � � � � � � �  p h p   � J   � � � �  � � � o   � ����� (0 downloadscriptpath downloadScriptPath �  � � � m   � � � � � � �    �  � � � o   � ����� 0 dirtodownload dirToDownload �  � � � m   � � � � � � �    �  � � � o   � ����� 0 whatdownload whatDownload �  � � � m   � � � � � � �    �  ��� � o   � ����� 	0 limit  ��   � o      ���� 0 commandtext commandText �  � � � I  � ��� ���
�� .sysodlogaskr        TEXT � b   � � � � � b   � � � � � b   � � � � � b   � � � � � b   � � � � � b   � � � � � m   � � � � � � �  W i l l   d o w n l o a d :   � o   � ����� 0 whatdownload whatDownload � m   � � � � � � �    ( l i m i t :   � o   � ����� 	0 limit   � m   � � � � � � � 
 )   t o   � o   � ����� 0 dirtodownload dirToDownload � m   � � � � � � � 
 .   O K ?��   �  � � � l  � ���������  ��  ��   �  � � � O  � � � � � I  � �������
�� .miscactvnull��� ��� obj ��  ��   � m   � � � ��                                                                                      @ alis    l  Macintosh HD               Λ��H+     WTerminal.app                                                     (��?z        ����  	                	Utilities     ΛŎ      �?A�       W   V  2Macintosh HD:Applications: Utilities: Terminal.app    T e r m i n a l . a p p    M a c i n t o s h   H D  #Applications/Utilities/Terminal.app   / ��   �  � � � O   �g � � � k   �f � �  � � � I  � �������
�� .miscactvnull��� ��� obj ��  ��   �  � � � Z   �D � ����� � =  � � � � n   � � � � 1   ���
�� 
prun �  g   � � � m  ��
�� boovtrue � k  @ � �  � � � O    I ��
�� .prcskprsnull���     ctxt m   �  t ����
�� 
faal m  ��
�� eMdsKcmd��   m  �                                                                                  sevs  alis    �  Macintosh HD               Λ��H+     4System Events.app                                               ��A�y        ����  	                CoreServices    ΛŎ      �A�9       4   1   0  =Macintosh HD:System: Library: CoreServices: System Events.app   $  S y s t e m   E v e n t s . a p p    M a c i n t o s h   H D  -System/Library/CoreServices/System Events.app   / ��   � � V  @	
	 I 4;�~�}
�~ .sysodelanull��� ��� nmbr m  47 ?�z�G�{�}  
 C  !3 n  !/ 1  +/�|
�| 
pcnt n  !+ 1  '+�{
�{ 
tcnt 4  !'�z
�z 
cwin m  %&�y�y  1  /2�x
�x 
lnfd�  ��  ��   �  I EU�w
�w .coredoscnull��� ��� ctxt o  EH�v�v 0 commandtext commandText �u�t
�u 
kfil 4 KQ�s
�s 
cwin m  OP�r�r �t    l VV�q�q   F @ do script "php -r \" sleep(4); echo 'ECHO'; \"" in front window    � �   d o   s c r i p t   " p h p   - r   \ "   s l e e p ( 4 ) ;   e c h o   ' E C H O ' ;   \ " "   i n   f r o n t   w i n d o w �p I Vf�o !
�o .coredoscnull��� ��� ctxt  m  VY"" �## h o s a s c r i p t   - e   ' t e l l   a p p l i c a t i o n   " F i n d e r "   t o   a c t i v a t e '! �n$�m
�n 
kfil$ 4 \b�l%
�l 
cwin% m  `a�k�k �m  �p   � m   � �&&�                                                                                      @ alis    l  Macintosh HD               Λ��H+     WTerminal.app                                                     (��?z        ����  	                	Utilities     ΛŎ      �?A�       W   V  2Macintosh HD:Applications: Utilities: Terminal.app    T e r m i n a l . a p p    M a c i n t o s h   H D  #Applications/Utilities/Terminal.app   / ��   � '(' l hh�j�i�h�j  �i  �h  ( )�g) l hh�f�e�d�f  �e  �d  �g  ��   j k  l�** +,+ l ll�c-.�c  - ( " no auth file exists. Require Auth   . �// D   n o   a u t h   f i l e   e x i s t s .   R e q u i r e   A u t h, 010 O lx232 I rw�b�a�`
�b .miscactvnull��� ��� obj �a  �`  3 m  lo44�                                                                                      @ alis    l  Macintosh HD               Λ��H+     WTerminal.app                                                     (��?z        ����  	                	Utilities     ΛŎ      �?A�       W   V  2Macintosh HD:Applications: Utilities: Terminal.app    T e r m i n a l . a p p    M a c i n t o s h   H D  #Applications/Utilities/Terminal.app   / ��  1 565 O  y�787 k  �99 :;: I ��_�^�]
�_ .miscactvnull��� ��� obj �^  �]  ; <=< Z  ��>?�\�[> = ��@A@ n  ��BCB 1  ���Z
�Z 
prunC  g  ��A m  ���Y
�Y boovtrue? k  ��DD EFE O ��GHG I ���XIJ
�X .prcskprsnull���     ctxtI m  ��KK �LL  tJ �WM�V
�W 
faalM m  ���U
�U eMdsKcmd�V  H m  ��NN�                                                                                  sevs  alis    �  Macintosh HD               Λ��H+     4System Events.app                                               ��A�y        ����  	                CoreServices    ΛŎ      �A�9       4   1   0  =Macintosh HD:System: Library: CoreServices: System Events.app   $  S y s t e m   E v e n t s . a p p    M a c i n t o s h   H D  -System/Library/CoreServices/System Events.app   / ��  F O�TO V  ��PQP I ���SR�R
�S .sysodelanull��� ��� nmbrR m  ��SS ?�z�G�{�R  Q C  ��TUT n  ��VWV 1  ���Q
�Q 
pcntW n  ��XYX 1  ���P
�P 
tcntY 4  ���OZ
�O 
cwinZ m  ���N�N U 1  ���M
�M 
lnfd�T  �\  �[  = [�L[ I ���K\]
�K .coredoscnull��� ��� ctxt\ b  ��^_^ b  ��`a` b  ��bcb m  ��dd �ee  c d  c o  ���J�J  0 projectdirpath projectDirPatha m  ��ff �gg  ;   p h p   - S  _ o  ���I�I 0 serveradress serverAdress] �Hh�G
�H 
kfilh 4 ���Fi
�F 
cwini m  ���E�E �G  �L  8 m  y|jj�                                                                                      @ alis    l  Macintosh HD               Λ��H+     WTerminal.app                                                     (��?z        ����  	                	Utilities     ΛŎ      �?A�       W   V  2Macintosh HD:Applications: Utilities: Terminal.app    T e r m i n a l . a p p    M a c i n t o s h   H D  #Applications/Utilities/Terminal.app   / ��  6 k�Dk O  ��lml k  ��nn opo I ���C�B�A
�C .miscactvnull��� ��� obj �B  �A  p q�@q I ���?r�>
�? .GURLGURLnull��� ��� TEXTr b  ��sts m  ��uu �vv  h t t p : / /t o  ���=�= 0 serveradress serverAdress�>  �@  m m  ��ww�                                                                                  sfri  alis    N  Macintosh HD               Λ��H+     V
Safari.app                                                       !L͜�"        ����  	                Applications    ΛŎ      ͜��       V  %Macintosh HD:Applications: Safari.app    
 S a f a r i . a p p    M a c i n t o s h   H D  Applications/Safari.app   / ��  �D   g x�<x l ���;�:�9�;  �:  �9  �<   . m    yy�                                                                                  MACS  alis    t  Macintosh HD               Λ��H+     4
Finder.app                                                      %B�`|Y        ����  	                CoreServices    ΛŎ      �`D       4   1   0  6Macintosh HD:System: Library: CoreServices: Finder.app   
 F i n d e r . a p p    M a c i n t o s h   H D  &System/Library/CoreServices/Finder.app  / ��   , z�8z l   �7�6�5�7  �6  �5  �8  ��       
�4{|    }~�3�4  { �2�1�0�/�.�-�,�+
�2 .aevtoappnull  �   � ****�1 0 
projectdir 
projectDir�0 0 authfile authFile�/ 0 serveradress serverAdress�. 0 homepath homePath�- 0 authfilepath authFilePath�,  0 projectdirpath projectDirPath�+  0 authfileexists authFileExists| �* �)�(���'
�* .aevtoappnull  �   � ****�)  �(  �  � B �& �%  �$y�#�"�!� � H� U���� }����� �� ����� � �� � � � ��� � � � � ����
�	������"Kdfwu��& 0 
projectdir 
projectDir�% 0 authfile authFile�$ 0 serveradress serverAdress
�# .miscactvnull��� ��� obj 
�" 
home
�! 
utxt
�  
psxp� 0 homepath homePath� 0 authfilepath authFilePath�  0 projectdirpath projectDirPath
� 
psxf
� .coredoexbool        obj �  0 authfileexists authFileExists� (0 downloadscriptpath downloadScriptPath
� 
cwin
� 
fvtg
� 
ctxt� 0 dirtodownload dirToDownload
� 
dtxt
� .sysodlogaskr        TEXT
� 
rslt
� 
ttxt� 0 whatdownload whatDownload� 	0 limit  � � 0 commandtext commandText
� 
prun
� 
faal
�
 eMdsKcmd
�	 .prcskprsnull���     ctxt
� 
tcnt
� 
pcnt
� 
lnfd
� .sysodelanull��� ��� nmbr
� 
kfil
� .coredoscnull��� ��� ctxt
� .GURLGURLnull��� ��� TEXT�'�E�O�E�O�E�O��*j O*�,�&�,E�O����mv%E�O���lv%E�O� )a �/j E` UO_ !��a lv%E` O*a k/a ,a &�,E` Oa a a l O_ a ,E` Oa  a a !l O_ a ,E` "Oa #_ a $_ a %_ a &_ "a 'v%E` (Oa )_ %a *%_ "%a +%_ %a ,%j Oa - *j UOa - p*j O*a .,e  =a / a 0a 1a 2l 3UO "h*a k/a 4,a 5,_ 6a 7j 8[OY��Y hO_ (a 9*a k/l :Oa ;a 9*a k/l :UOPY �a - *j UOa - g*j O*a .,e  =a / a <a 1a 2l 3UO "h*a k/a 4,a 5,_ 6a 7j 8[OY��Y hOa =�%a >%�%a 9*a k/l :UOa ? *j Oa @�%j AUOPUOP} ���  / U s e r s / d e a n a r /~ ��� : / U s e r s / d e a n a r / S C S y n c / a u t h . t x t ��� * / U s e r s / d e a n a r / S C S y n c /
�3 boovfals ascr  ��ޭ