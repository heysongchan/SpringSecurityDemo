package com.example.securityDemo.Utils;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.util.List;

import org.springframework.stereotype.Component;

import com.alibaba.fastjson.JSON;

@Component
public class utils {
	static void putInt(byte[] b, int off, int val) {
		b[off + 3] = (byte) (val);
		b[off + 2] = (byte) (val >>> 8);
		b[off + 1] = (byte) (val >>> 16);
		b[off] = (byte) (val >>> 24);
	}

	static int getInt(byte[] b, int off) {
		return ((b[off + 3] & 0xFF)) + ((b[off + 2] & 0xFF) << 8) + ((b[off + 1] & 0xFF) << 16) + ((b[off]) << 24);
	}

	byte[] toBufWithLen(JSON json) {
		byte[] buf = null;
		if (json != null) {
			String jsonstr = json.toJSONString();
			try {
				byte[] tmp = jsonstr.getBytes("utf-8");
				int len = tmp.length;
				buf = new byte[len + 4];
				putInt(buf, 0, len);
				System.arraycopy(tmp, 0, buf, 4, len);
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			}
		}
		return buf;
	}

	public void read(InputStream in) throws IOException {
		byte[] lenBuf = new byte[4];
		int i = -1;
		try {
			do {
				i = in.read(lenBuf, 0, 4);
				if (i != -1) {
					int size = getInt(lenBuf, 0);
					byte[] buf = new byte[size];
					i = in.read(buf, 0, buf.length);
					if (i != -1) {
						String jsonstr = new String(buf, "utf-8");
						Object obj = JSON.parse(jsonstr);
						System.out.println(obj);
					}
				}
			} while (i != -1);
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			in.close();

		}

	}

	public void write(List<JSON> list, OutputStream out) {
		try {
			for (JSON json : list) {
				byte[] buf = toBufWithLen(json);
				out.write(buf);
			}
		} catch (Exception e) {
			e.printStackTrace();
		} finally {
			if (out != null) {
				try {
					out.flush();
					out.close();
				} catch (IOException e) {
					e.printStackTrace();
				}

			}
		}
	}
}
