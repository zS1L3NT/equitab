import * as Contacts from "expo-contacts"

export const getPermission = async (): Promise<boolean> => {
	const { status } = await Contacts.getPermissionsAsync()
	switch (status) {
		case Contacts.PermissionStatus.GRANTED:
			console.log("Permission granted: CONTACTS")
			return true
		case Contacts.PermissionStatus.UNDETERMINED:
			console.log("Requesting permission: CONTACTS")
			await Contacts.requestPermissionsAsync()
			return await getPermission()
		case Contacts.PermissionStatus.DENIED:
			console.warn("Permission denied: CONTACTS")
			return false
	}
}
