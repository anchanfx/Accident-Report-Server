Accident-Report-Server
======================
  - ทำบน Eclipse (ติดตั้ง PHP TOOL PLUGIN ก่อน)
  - ใช้ Git ผ่าน Egit ที่เป็น Plug-in ของ Eclipse
  - หลังจาก Pull Repo จาก Github เส็รจแล้วทุกครั้ง โปรเจคที่ได้อาจจะ Error เพราะมันขาดโฟลเด้อ /bin/ และ /gen/ ให้ Clean Project ก่อนทุกครั้ง (บังคับให้มัน Compile)
  - ก่อนจะ Push โปรเจคที่ทำจากเครื่องขึ้น Github ให้ Fetch->Merge หรือ Pull เพื่อเช็คดูว่า Version ตั้งแต่ตอน Pull มาครั้งล่าสุดมันตรงกันกับ Version บน Github ในตอนนั้นหรือป่าว ไม่งั้นมันอาจจะ ERROR    กรณีที่มีคน Push Version ใหม่ขึ้นมา *ก่อนที* เราจะ Push งานที่เราแก้ไข + เพิ่มเติมขึ้น Github (คล้ายๆกับว่า Version งาน ที่เราทำงานอยู่ไม่เป็น Ver. ล่าสุด)
