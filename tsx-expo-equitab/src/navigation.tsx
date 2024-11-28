import { AppIcon } from "@/config/theme"
import FriendsScreen from "@/screens/friends"
import AddFriendsScreen from "@/screens/friends/add-friends"
import HomeScreen from "@/screens/home"
import CreateLedgerScreen from "@/screens/home/create-ledger"
import SettingsScreen from "@/screens/settings"
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { createNativeStackNavigator } from "@react-navigation/native-stack"

const RootStack = createNativeStackNavigator<RootStackParamList>()
export type RootStackParamList = Record<"App" | "AddFriends" | "CreateLedger", undefined>
export function RootStackNavigation() {
	return (
		<RootStack.Navigator screenOptions={{ headerShown: false }}>
			<RootStack.Screen name="App" component={RootTabNavigation} />
			<RootStack.Screen name="AddFriends" component={AddFriendsScreen} />
			<RootStack.Screen name="CreateLedger" component={CreateLedgerScreen} />
		</RootStack.Navigator>
	)
}

const RootTab = createBottomTabNavigator<RootTabParamList>()
export type RootTabParamList = Record<"Home" | "Friends" | "Settings", undefined>
export function RootTabNavigation() {
	return (
		<RootTab.Navigator initialRouteName="Home">
			<RootTab.Screen
				name="Home"
				component={HomeScreen}
				options={{ tabBarIcon: props => <AppIcon name="home" {...props} /> }}
			/>
			<RootTab.Screen
				name="Friends"
				component={FriendsScreen}
				options={{ tabBarIcon: props => <AppIcon name="people" {...props} /> }}
			/>
			<RootTab.Screen
				name="Settings"
				component={SettingsScreen}
				options={{ tabBarIcon: props => <AppIcon name="settings" {...props} /> }}
			/>
		</RootTab.Navigator>
	)
}
